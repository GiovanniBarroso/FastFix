<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
        'telefono',
        'estado', // 'pendiente', 'respondido', etc.
    ];
}
