<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ConsultarApisController extends Controller
{
    protected $TOKEN_PRINCIPAL;
    protected $URL_PRINCIPAL;

    protected $URL_SECUNDARIA;

    public function __construct()
    {
        $this->TOKEN_PRINCIPAL = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzNzc0NiIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6ImNvbnN1bHRvciJ9.JXs5g8KEzCbv85ECTfroeTQNvX3siphuyV51sRKNiH8';

        $this->URL_PRINCIPAL = 'https://api.factiliza.com/pe/v1/';

        $this->URL_SECUNDARIA = 'https://api.factiliza.com/pe/v1/';
    }


    public function BuscarDocumentoUsuario(Request $request)
    {
        $documento = trim($request->input('documento', ''));

        if (empty($documento) || strlen($documento) !== 8 || !ctype_digit($documento)) {
            return response()->json([
                'success' => false,
                'encontrado' => false,
                'message' => 'El número de DNI debe contener exactamente 8 dígitos numéricos.',
            ], 422);
        }

        $existe = \App\Models\Usuario::where('dni', $documento)->exists();

        $json = $this->buscarUsuario($documento);

        if (isset($json['estado']) && $json['estado'] == 200 && !empty($json['datos'])) {
            return response()->json([
                'success' => true,
                'encontrado' => true,
                'estados' => 200,
                'datos' => $json['datos'],
                'ya_registrado' => $existe,
                'message' => $existe 
                    ? 'Aviso: Este DNI ya figura en la base de datos (modo prueba habilitado).' 
                    : 'DNI consultado exitosamente en RENIEC.',
            ]);
        } else if (isset($json['estado']) && $json['estado'] == 400) {
            return response()->json([
                'success' => false,
                'encontrado' => false,
                'estados' => 400,
                'message' => $json['datos']['message'] ?? 'No se encontró información para el DNI ingresado.',
            ]);
        }

        return response()->json([
            'success' => false,
            'encontrado' => false,
            'message' => 'No se encontraron datos para el DNI ingresado en RENIEC.',
        ]);
    }

    public function buscarUsuario($dniUsuario)
    {

        $code = $this->TOKEN_PRINCIPAL;
        $url = $this->URL_PRINCIPAL . 'dni/info/' . $dniUsuario;

        $consult = curl_init();

        curl_setopt_array($consult, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $code"),
        ));

        $result = curl_exec($consult);
        curl_close($consult);

        $json = json_decode($result);

        //dd($url );

        if ($json === null) {
            return [
                'estado' => false,
                'encontrado' => false
            ];
        }


        if ($json->status == 200) {
            return [
                'encontrado' => true,
                'estado' => $json->status,
                'datos' => [
                    'dni' => $dniUsuario,
                    'nom' => $json->data->nombres,
                    'aPa' => $json->data->apellido_paterno,
                    'aMa' => $json->data->apellido_materno,
                    //'fecNac' => $json->data->fecha_nacimiento,
                    'edad' => '',
                    //'drc' => $json->data->direccion,
                    'ubi' => '',
                    'distritos' => '',
                    'provincias' => '',
                    //'sex' => $json->data->sexo,
                ]
            ];
        } else if ($json->status == 400) {
            return [
                'est' => false,
                'estado' => $json->status,
                'datos' => [
                    'status' => $json->status,
                    'message' => $json->message,
                ]
            ];
        }
    }

    public function BuscarDocumentoTrabajadores(Request $request)
    {

        //dd($request->input('cas_DocumentoNumeroBuscar'));

        $json = $this->buscarDniCas($request->input('documentoBuscar'));



        if ($json['estado'] == 200) {
            return [
                'encontrado' => true,
                'estados' => $json['estado'],
                'datos' => $json['datos']
            ];
        } else if ($json['estado'] == 400) {
            return [
                'est' => false,
                'estados' => $json['estado'],
                'datos' => $json['datos']
            ];
        }
    }


    public function buscarDniCas($dniCas)
    {

        $code = $this->TOKEN_PRINCIPAL;
        $url = $this->URL_PRINCIPAL . 'dni/info/' . $dniCas;

        $consult = curl_init();

        curl_setopt_array($consult, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $code"),
        ));

        $result = curl_exec($consult);
        curl_close($consult);

        $json = json_decode($result);

        //dd($jsonCas);

        if ($json === null) {
            return [
                'estado' => false,
                'encontrado' => false
            ];
        }


        if ($json->status === 200) {
            return [
                'encontrado' => true,
                'estado' => $json->status,
                'datos' => [
                    'dni' => $dniCas,
                    'nom' => $json->data->nombres,
                    'aPa' => $json->data->apellido_paterno,
                    'aMa' => $json->data->apellido_materno,
                    'fecNac' => $json->data->fecha_nacimiento,
                    'edad' => '',
                    'drc' => $json->data->direccion,
                    'ubi' => '',
                    'distritos' => '',
                    'provincias' => '',
                    'sex' => $json->data->sexo,
                ]
            ];
        } else if ($json->status === 400) {
            return [
                'est' => false,
                'estado' => $json->status,
                'datos' => [
                    'status' => $json->status,
                    'message' => $json->message,
                ]
            ];
        }
    }
}
