<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importacion extends Model
{
    //
    use HasFactory;

    // 👇 Corrige la pluralización
    protected $table = 'importaciones';
}
