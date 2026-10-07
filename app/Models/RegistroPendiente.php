<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroPendiente extends Model
{
    protected $table = 'registro_pendiente';

    protected $fillable = [
        'dni',
        'nombres',
        'apellidos',
        'nombre_completo',
        'correo',
        'nickname',
        'password',
        'token',
        'expira_en',
        'verificado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'verificado' => 'boolean',
    ];

    /**
     * Verifica si el token ha expirado.
     */
    public function estaExpirado(): bool
    {
        return now()->greaterThan($this->expira_en);
    }
}
