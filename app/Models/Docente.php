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
    'nombre',
    'apellidos',
    'titulo',
    'especialidad',
    'correo_institucional',
    'telefono',
    'estado',
    ];
    public function usuario()
{
    return $this->belongsTo(Usuario::class, 'usuario_id');
}

}
