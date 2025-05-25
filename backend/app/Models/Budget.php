<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mensaje',
        'estado',
        'respuesta_admin',
        'presupuesto_estimado',
        'fecha_respuesta',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
