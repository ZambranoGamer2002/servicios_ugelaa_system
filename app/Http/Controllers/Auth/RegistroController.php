<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ConsultarApisController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\RegistroPendiente;
use App\Models\TipoUsuario;
use App\Mail\VerificacionRegistroMail;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function index()
    {
        return view('auth.registro');
    }

    /**
     * Busca el DNI en la API RENIEC (reutiliza la lógica existente).
     */
    public function buscarDni(Request $request)
    {
        $dni = trim($request->input('dni') ?? $request->input('documento') ?? '');

        if (strlen($dni) !== 8 || !ctype_digit($dni)) {
            return response()->json([
                'success' => false,
                'message' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
            ], 422);
        }

        $apiController = new ConsultarApisController();
        $resultado = $apiController->buscarUsuario($dni);

        if (isset($resultado['encontrado']) && $resultado['encontrado'] === true && $resultado['estado'] == 200) {
            $existeUsuario = Usuario::where('dni', $dni)->first();

            return response()->json([
                'success' => true,
                'encontrado' => true,
                'datos' => $resultado['datos'],
                'ya_registrado' => $existeUsuario ? true : false,
                'aviso' => $existeUsuario ? 'Este DNI ya figura registrado en el sistema, pero cargamos los datos de RENIEC para la prueba.' : null,
            ]);
        } elseif (isset($resultado['estado']) && $resultado['estado'] == 400) {
            return response()->json([
                'success' => false,
                'message' => $resultado['datos']['message'] ?? 'El DNI debe tener 8 dígitos.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo encontrar información para este DNI en RENIEC. Verifique el número e intente nuevamente.',
            ]);
        }
    }

    /**
     * Procesa el formulario de registro y envía email de verificación.
     */
    public function registrar(Request $request)
    {
        $rules = [
            'dni'       => 'required|digits:8|numeric',
            'nombres'   => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo'    => 'required|email|max:255',
            'nickname'  => 'required|string|max:100|min:4',
            'password'  => 'required|string|min:6|confirmed',
        ];

        $messages = [
            'dni.required'       => 'El <strong>DNI</strong> es obligatorio.',
            'dni.digits'         => 'El <strong>DNI</strong> debe tener exactamente 8 dígitos.',
            'nombres.required'   => 'Los <strong>nombres</strong> son obligatorios.',
            'apellidos.required' => 'Los <strong>apellidos</strong> son obligatorios.',
            'correo.required'    => 'El <strong>correo electrónico</strong> es obligatorio.',
            'correo.email'       => 'Ingrese un <strong>correo electrónico</strong> válido.',
            'nickname.required'  => 'El <strong>nombre de usuario</strong> es obligatorio.',
            'nickname.min'       => 'El <strong>nombre de usuario</strong> debe tener al menos 4 caracteres.',
            'password.required'  => 'La <strong>contraseña</strong> es obligatoria.',
            'password.min'       => 'La <strong>contraseña</strong> debe tener al menos 6 caracteres.',
            'password.confirmed' => 'Las <strong>contraseñas</strong> no coinciden.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errores' => $validator->errors(),
            ], 422);
        }

        // Verificar si el DNI ya está registrado como usuario
        $existeDni = Usuario::where('dni', $request->dni)->first();
        if ($existeDni) {
            if (app()->environment('local')) {
                // En desarrollo local, permitir re-probar el registro del DNI de prueba
                RegistroPendiente::where('dni', $request->dni)->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Este DNI ya se encuentra registrado en el sistema.',
                ], 422);
            }
        }

        // Verificar si el nickname ya existe
        $existeNickname = Usuario::where('nickname', strtoupper($request->nickname))->first();
        if ($existeNickname && (!app()->environment('local') || $existeNickname->dni !== $request->dni)) {
            return response()->json([
                'success' => false,
                'message' => 'Este nombre de usuario ya está en uso. Elija otro.',
            ], 422);
        }

        // Verificar si el correo ya está registrado
        $existeCorreo = Usuario::where('email', $request->correo)->first();
        if ($existeCorreo && (!app()->environment('local') || $existeCorreo->dni !== $request->dni)) {
            return response()->json([
                'success' => false,
                'message' => 'Este correo electrónico ya está registrado.',
            ], 422);
        }

        // Invalidar registros pendientes anteriores del mismo DNI
        RegistroPendiente::where('dni', $request->dni)
            ->where('verificado', false)
            ->delete();

        // Crear registro pendiente con token
        $token = Str::random(64);
        $apellidos = $request->apellidos;
        $nombres = $request->nombres;
        $nombreCompleto = strtoupper($apellidos) . ', ' . strtoupper($nombres);

        $registro = RegistroPendiente::create([
            'dni'             => $request->dni,
            'nombres'         => strtoupper($nombres),
            'apellidos'       => strtoupper($apellidos),
            'nombre_completo' => $nombreCompleto,
            'correo'          => $request->correo,
            'nickname'        => strtoupper($request->nickname),
            'password'        => Hash::make($request->password),
            'token'           => $token,
            'expira_en'       => now()->addMinutes(10),
        ]);

        // Enviar email de verificación
        try {
            Mail::to($request->correo)->send(
                new VerificacionRegistroMail($nombreCompleto, $token)
            );
        } catch (\Exception $e) {
            // Si falla el envío de correo, eliminar el registro pendiente
            $registro->delete();

            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el correo de verificación. Verifique que el correo sea válido e intente nuevamente.',
            ], 500);
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Se envió un enlace de verificación a su correo electrónico.',
            'correo'     => $request->correo,
            'registro_id' => $registro->id,
        ]);
    }

    /**
     * Reenvía el correo de verificación (permite cambiar correo).
     */
    public function reenviar(Request $request)
    {
        $request->validate([
            'registro_id' => 'required|integer',
            'correo'      => 'required|email|max:255',
            'password'    => 'required|string|min:6|confirmed',
        ]);

        $registro = RegistroPendiente::where('id', $request->registro_id)
            ->where('verificado', false)
            ->first();

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró el registro pendiente. Inicie el proceso nuevamente.',
            ], 404);
        }

        // Verificar si el nuevo correo ya está registrado por otro usuario distinto
        $existeCorreo = Usuario::where('email', $request->correo)->first();
        if ($existeCorreo && (!app()->environment('local') || $existeCorreo->dni !== $registro->dni)) {
            return response()->json([
                'success' => false,
                'message' => 'Este correo electrónico ya está registrado en el sistema.',
            ], 422);
        }

        // Generar nuevo token y actualizar datos
        $nuevoToken = Str::random(64);

        $registro->update([
            'correo'    => $request->correo,
            'password'  => Hash::make($request->password),
            'token'     => $nuevoToken,
            'expira_en' => now()->addMinutes(10),
        ]);

        // Reenviar email
        try {
            Mail::to($request->correo)->send(
                new VerificacionRegistroMail($registro->nombre_completo, $nuevoToken)
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el correo. Verifique la dirección e intente nuevamente.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Se reenvió el enlace de verificación al nuevo correo.',
            'correo'  => $request->correo,
        ]);
    }

    /**
     * Verifica el token del email y completa el registro.
     */
    public function verificar($token)
    {
        $registro = RegistroPendiente::where('token', $token)
            ->where('verificado', false)
            ->first();

        // Token no encontrado
        if (!$registro) {
            return view('auth.verificacion.error', [
                'titulo'  => 'Enlace Inválido',
                'mensaje' => 'El enlace de verificación no es válido o ya fue utilizado.',
            ]);
        }

        // Token expirado
        if ($registro->estaExpirado()) {
            $registro->delete();

            return view('auth.verificacion.error', [
                'titulo'  => 'Enlace Expirado',
                'mensaje' => 'El enlace de verificación ha expirado. Tiene un máximo de 10 minutos para verificar su registro. Por favor, regístrese nuevamente.',
            ]);
        }

        // Verificaciones finales antes de crear el usuario
        $existeDni = Usuario::where('dni', $registro->dni)->first();
        if ($existeDni) {
            if (app()->environment('local')) {
                // En modo local, actualizar el usuario existente
                $existeDni->update([
                    'nombres'         => $registro->nombres,
                    // Simplificando los apellidos a paterno por ahora, o podrías dividirlos si es posible
                    'apellido_paterno'=> $registro->apellidos, 
                    'nickname'        => $registro->nickname,
                    'email'           => $registro->correo,
                    'email_verified_at' => now(),
                    'estado'          => 1,
                ]);

                DB::table('usuarios')->where('id', $existeDni->id)->update([
                    'password' => $registro->password,
                ]);

                $registro->update(['verificado' => true]);
                return view('auth.verificacion.exitosa');
            } else {
                $registro->delete();
                return view('auth.verificacion.error', [
                    'titulo'  => 'DNI Ya Registrado',
                    'mensaje' => 'Este DNI ya se encuentra registrado en el sistema.',
                ]);
            }
        }

        $existeNickname = Usuario::where('nickname', $registro->nickname)->first();
        if ($existeNickname && (!app()->environment('local') || $existeNickname->dni !== $registro->dni)) {
            $registro->delete();
            return view('auth.verificacion.error', [
                'titulo'  => 'Usuario Ya Existe',
                'mensaje' => 'El nombre de usuario elegido ya está en uso. Regístrese nuevamente con otro nombre de usuario.',
            ]);
        }

        // Buscar tipo de usuario por defecto "NORMAL" o el primer tipo disponible
        // Removed TipoUsuario check as we now use Spatie roles

        // Crear el usuario definitivo
        $usuario = Usuario::create([
            'nombres'         => $registro->nombres,
            'apellido_paterno'=> $registro->apellidos,
            'nickname'        => $registro->nickname,
            'password'        => $registro->password, // ya está hasheada
            'email'           => $registro->correo,
            'dni'             => $registro->dni,
            'email_verified_at' => now(),
            'estado'          => 1,
        ]);

        // Asignar rol por defecto
        $usuario->assignRole('NORMAL');

        // Evitar que el mutator de password vuelva a hashear
        // La contraseña ya viene hasheada desde registro_pendiente
        DB::table('usuarios')->where('id', $usuario->id)->update([
            'password' => $registro->password,
        ]);

        // Marcar registro como verificado
        $registro->update(['verificado' => true]);

        return view('auth.verificacion.exitosa');
    }
}
