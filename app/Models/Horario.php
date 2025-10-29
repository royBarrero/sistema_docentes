<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'docente_id',
        'grupo_id',
        'aula_id',
        'gestion_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    // Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }

    public function gestion()
    {
        return $this->belongsTo(GestionAcademica::class, 'gestion_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'horario_id');
    }

    // Accessor para el nombre del día
    public function getDiaNombreAttribute()
    {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];
        return $dias[$this->dia_semana] ?? '-';
    }
}