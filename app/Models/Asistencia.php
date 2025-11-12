<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'horario_id',
        'fecha',
        'hora_registro',
        'estado',
        'observacion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_registro' => 'datetime:H:i',
    ];

    // Relación con Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    // Verificar si se puede registrar asistencia ahora
    public static function puedeRegistrar($horario, $fecha = null)
    {
        $fecha = $fecha ?? Carbon::now()->format('Y-m-d');
        $hora_actual = Carbon::now();
        
        // Obtener hora de inicio y fin del horario
        $hora_inicio = Carbon::parse($horario->hora_inicio);
        $hora_fin = Carbon::parse($horario->hora_fin);
        
        // Permitir registro 30 minutos antes y hasta el final de la clase
        $hora_permitida_inicio = $hora_inicio->copy()->subMinutes(30);
        $hora_permitida_fin = $hora_fin;
        
        return $hora_actual->between($hora_permitida_inicio, $hora_permitida_fin);
    }

    // Determinar estado según hora de registro
    public static function determinarEstado($horario, $hora_registro = null)
    {
        $hora_registro = $hora_registro ?? Carbon::now();
        $hora_inicio = Carbon::parse($horario->hora_inicio);
        
        // Si llega 15 minutos después del inicio, es tardanza
        $limite_tardanza = $hora_inicio->copy()->addMinutes(15);
        
        if ($hora_registro->greaterThan($limite_tardanza)) {
            return 'Retraso';
        }
        
        return 'Presente';
    }
}