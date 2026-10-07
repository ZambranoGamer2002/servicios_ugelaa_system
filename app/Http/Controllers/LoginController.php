<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nickname' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'nickname.required' => 'Ingrese su usuario o correo electrónico.',
            'password.required' => 'Ingrese su contraseña.',
        ]);

        $loginInput = trim($request->input('nickname') ?? $request->input('email') ?? '');
        $password = $request->password;

        // Si es correo electrónico
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => strtolower($loginInput), 'password' => $password, 'estado' => 1];
            if (Auth::attempt($credentials)) {
                if ($request->hasSession()) {
                    $request->session()->regenerate();
                }
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        } else {
            // Intentar con nickname exacto o en mayúsculas
            if (Auth::attempt(['nickname' => $loginInput, 'password' => $password, 'estado' => 1]) ||
                Auth::attempt(['nickname' => strtoupper($loginInput), 'password' => $password, 'estado' => 1])) {
                if ($request->hasSession()) {
                    $request->session()->regenerate();
                }
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return redirect('login')
            ->withInput(['nickname' => $loginInput])
            ->with('status', 'Usuario o contraseña incorrectos. Inténtelo nuevamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
