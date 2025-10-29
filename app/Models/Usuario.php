<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable, HasFactory;

    // Nombre real de la tabla
    protected $table = 'usuarios';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'nombre_completo',
        'email',
        'telefono',
        'password_hash',
        'estado',
        'role_id',
    ];

    // Ocultar campos sensibles
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // Laravel espera una columna llamada "password"
    // Así que le decimos que use nuestra columna password_hash
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Relación con Rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }
}