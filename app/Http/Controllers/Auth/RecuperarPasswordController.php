<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\PasswordResetCustom;
use App\Mail\RecuperarPasswordMail;

class RecuperarPasswordController extends Controller
{
    /**
     * Muestra el formulario de "ingrese su correo".
     */
    public function index()
    {
        return view('auth.password.recuperar');
    }

    /**
     * Envía el enlace de recuperación al correo.
     */
    public function enviarEnlace(Request $request)
    {
        $rules = [
            'correo' => 'required|email|max:255',
        ];

        $messages = [
            'correo.required' => 'El <strong>correo electrónico</strong> es obligatorio.',
            'correo.email'    => 'Ingrese un <strong>correo electrónico</strong> válido.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errores' => $validator->errors(),
            ], 422);
        }

        // Buscar usuario por correo
        $usuario = Usuario::where('email', $request->correo)->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró una cuenta asociada a este correo electrónico.',
            ], 404);
        }

        // Invalidar tokens anteriores de este correo
        PasswordResetCustom::where('correo', $request->correo)
            ->where('usado', false)
            ->update(['usado' => true]);

        // Crear nuevo token
        $token = Str::random(64);

        PasswordResetCustom::create([
            'correo'    => $request->correo,
            'token'     => $token,
            'expira_en' => now()->addMinutes(30),
        ]);

        // Enviar email
        $nombreCompleto = $usuario->nombre_completo ?? ($usuario->apellidos . ', ' . $usuario->nombres);

        try {
            Mail::to($request->correo)->send(
                new RecuperarPasswordMail($nombreCompleto, $token)
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo enviar el correo. Intente nuevamente más tarde.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Se envió un enlace de recuperación a su correo electrónico.',
        ]);
    }

    /**
     * Muestra el formulario para establecer nueva contraseña.
     */
    public function formularioReset($token)
    {
        $reset = PasswordResetCustom::where('token', $token)
            ->where('usado', false)
            ->first();

        if (!$reset) {
            return view('auth.verificacion.error', [
                'titulo'  => 'Enlace Inválido',
                'mensaje' => 'El enlace de recuperación no es válido o ya fue utilizado.',
            ]);
        }

        if ($reset->estaExpirado()) {
            $reset->update(['usado' => true]);

            return view('auth.verificacion.error', [
                'titulo'  => 'Enlace Expirado',
                'mensaje' => 'El enlace de recuperación ha expirado. Solicite uno nuevo desde la pantalla de inicio de sesión.',
            ]);
        }

        return view('auth.password.resetear', [
            'token'  => $token,
            'correo' => $reset->correo,
        ]);
    }

    /**
     * Procesa el cambio de contraseña.
     */
    public function resetear(Request $request)
    {
        $rules = [
            'token'    => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ];

        $messages = [
            'password.required'  => 'La <strong>nueva contraseña</strong> es obligatoria.',
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

        // Buscar token válido
        $reset = PasswordResetCustom::where('token', $request->token)
            ->where('usado', false)
            ->first();

        if (!$reset) {
            return response()->json([
                'success' => false,
                'message' => 'El enlace de recuperación no es válido o ya fue utilizado.',
            ], 404);
        }

        if ($reset->estaExpirado()) {
            $reset->update(['usado' => true]);

            return response()->json([
                'success' => false,
                'message' => 'El enlace de recuperación ha expirado. Solicite uno nuevo.',
            ], 422);
        }

        // Actualizar contraseña del usuario
        $usuario = Usuario::where('email', $reset->correo)->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la cuenta asociada.',
            ], 404);
        }

        $usuario->password = $request->password;
        $usuario->save();

        // Marcar token como usado
        $reset->update(['usado' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Su contraseña ha sido actualizada exitosamente.',
            'ruta'    => url('login'),
        ]);
    }
}
