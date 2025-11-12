<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_fin' => 'datetime:H:i',
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
// Método para verificar si ya tiene asistencia hoy
public function tieneAsistenciaHoy()
{
    return $this->asistencias()
                ->whereDate('fecha', now()->format('Y-m-d'))
                ->exists();
}
    // Accessor para nombre del día
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

    // Validar si hay conflicto con otro horario
    public static function tieneConflicto($docente_id, $aula_id, $grupo_id, $gestion_id, $dia_semana, $hora_inicio, $hora_fin, $horario_id = null)
    {
        $query = self::where('gestion_id', $gestion_id)
                     ->where('dia_semana', $dia_semana)
                     ->where('estado', 'Activo')
                     ->where(function($q) use ($hora_inicio, $hora_fin) {
                         $q->whereBetween('hora_inicio', [$hora_inicio, $hora_fin])
                           ->orWhereBetween('hora_fin', [$hora_inicio, $hora_fin])
                           ->orWhere(function($q2) use ($hora_inicio, $hora_fin) {
                               $q2->where('hora_inicio', '<=', $hora_inicio)
                                  ->where('hora_fin', '>=', $hora_fin);
                           });
                     });

        // Excluir el horario actual si es edición
        if ($horario_id) {
            $query->where('id', '!=', $horario_id);
        }

        // Verificar conflictos
        $conflictos = [];

        // Conflicto de docente
        if ($query->clone()->where('docente_id', $docente_id)->exists()) {
            $conflictos[] = 'El docente ya tiene asignado un horario en este día y hora';
        }

        // Conflicto de aula
        if ($query->clone()->where('aula_id', $aula_id)->exists()) {
            $conflictos[] = 'El aula ya está ocupada en este día y hora';
        }

        // Conflicto de grupo
        if ($query->clone()->where('grupo_id', $grupo_id)->exists()) {
            $conflictos[] = 'El grupo ya tiene asignada una clase en este día y hora';
        }

        return $conflictos;
    }
}