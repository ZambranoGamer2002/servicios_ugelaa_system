<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class InicioController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth')->only('index');
    }

    public function index()
    {

        $opciones = [
            'titlePage' => 'Bienvenido(a)',
        ];

        return view('inicio.index', $opciones);
    }

    public function limpiar()
    {
        Artisan::call('route:clear');
        Artisan::call('route:cache');

        Artisan::call('view:clear');
        Artisan::call('view:cache');

        Artisan::call('cache:clear');

        // Capture previous URL or default to home '/'
        $previousUrl = url()->previous() !== url()->current() ? url()->previous() : '/';

        return view('inicio.limpiar', ['previousUrl' => $previousUrl]);
    }
}
