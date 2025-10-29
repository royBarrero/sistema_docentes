<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'usuario_id',
        'ci',
        'titulo',
        'especialidad',
        'correo_institucional',
        'telefono',
        'estado',
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con Horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'docente_id');
    }

    // Horarios de la gestión actual
    public function horariosActuales()
    {
        return $this->hasMany(Horario::class, 'docente_id')
                    ->where('estado', 'Activo')
                    ->whereHas('gestion', function($query) {
                        $query->where('estado', 'Activo');
                    });
    }
}
