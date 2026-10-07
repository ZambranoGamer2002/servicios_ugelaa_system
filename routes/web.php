<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\RecuperarPasswordController;
use App\Http\Controllers\ConsultarApisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InicioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Autenticación (Login / Logout)
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registro público
Route::get('registro', [RegistroController::class, 'index'])->name('registro');
Route::get('register', [RegistroController::class, 'index'])->name('register');
Route::post('registro/buscar-dni', [RegistroController::class, 'buscarDni'])->name('registro.buscar-dni');
Route::post('buscar-documento', [RegistroController::class, 'buscarDni'])->name('buscar.documento');
Route::post('registro', [RegistroController::class, 'registrar'])->name('registro.enviar');
Route::post('register', [RegistroController::class, 'registrar']);
Route::post('registro/reenviar', [RegistroController::class, 'reenviar'])->name('registro.reenviar');
Route::post('email/resend', [RegistroController::class, 'reenviar'])->name('verification.resend');
Route::get('registro/verificar/{token}', [RegistroController::class, 'verificar'])->name('registro.verificar');

// Recuperar contraseña
Route::get('recuperar-password', [RecuperarPasswordController::class, 'index'])->name('password.solicitar');
Route::get('password/reset', [RecuperarPasswordController::class, 'index'])->name('password.request');
Route::post('recuperar-password', [RecuperarPasswordController::class, 'enviarEnlace'])->name('password.enviar');
Route::post('password/email', [RecuperarPasswordController::class, 'enviarEnlace'])->name('password.email');
Route::get('reset-password/{token}', [RecuperarPasswordController::class, 'formularioReset'])->name('password.reset');
Route::post('reset-password', [RecuperarPasswordController::class, 'resetear'])->name('password.resetear');
Route::post('password/reset', [RecuperarPasswordController::class, 'resetear'])->name('password.update');

// Home / Dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Limpiar Cache
Route::get('/limpiar', [InicioController::class, 'limpiar'])->name('limpiar');
