<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = true;

    protected $fillable = [
        'dni',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'sexo',
        'email',
        'nickname',
        'password',
        'estado',
        'tipoUsuario_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'correo_verificado_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'tipoUsuario_id');
    }

    public function setPasswordAttribute($value)
    {
        // Solo hashear si no está ya hasheado
        $this->attributes['password'] = (strlen($value) === 60 && preg_match('/^\$2[ayb]\$.{56}$/', $value))
            ? $value
            : bcrypt($value);
    }

    public function setNombresAttribute($value)
    {
        $this->attributes['nombres'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setApellidoPaternoAttribute($value)
    {
        $this->attributes['apellido_paterno'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setApellidoMaternoAttribute($value)
    {
        $this->attributes['apellido_materno'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setNicknameAttribute($value)
    {
        $this->attributes['nickname'] = strtoupper(trim($value));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
