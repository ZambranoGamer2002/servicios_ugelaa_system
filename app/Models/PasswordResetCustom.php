<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetCustom extends Model
{
    protected $table = 'password_resets_custom';

    public $timestamps = false;

    protected $fillable = [
        'correo',
        'token',
        'expira_en',
        'usado',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado' => 'boolean',
    ];

    /**
     * Verifica si el token ha expirado.
     */
    public function estaExpirado(): bool
    {
        return now()->greaterThan($this->expira_en);
    }
}
