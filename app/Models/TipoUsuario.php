<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    protected $table = 'tipo_usuario';
    public $timestamps = false;

    protected $fillable = [
        'descripcion', 'accesos'
    ];

    public function usuario()
    {
        return $this->hasMany(Usuario::class);
    }

    public function setDescripcionAttribute($value)
    {
        $this->attributes['descripcion'] = strtoupper($value);
    }
}
