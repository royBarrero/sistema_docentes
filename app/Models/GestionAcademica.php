<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GestionAcademica extends Model
{
    //
    use HasFactory;

    // 👇 Este es el cambio importante
    protected $table = 'gestiones_academicas';
}
