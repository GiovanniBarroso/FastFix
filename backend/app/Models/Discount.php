<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'valor',
        'tipo',
        'inicio',
        'fin',
        'activo',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function isActive(): bool
    {
        $now = now();
        return $this->activo &&
            (!$this->inicio || $this->inicio <= $now) &&
            (!$this->fin || $this->fin >= $now);
    }

    public function getDescuentoFormateadoAttribute()
    {
        return $this->tipo === 'porcentaje'
            ? "{$this->valor}%"
            : number_format($this->valor, 2) . "€";
    }
}
