<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'valor',
        'tipo',
        'inicio',
        'fin',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isActive(): bool
    {
        $now = now();
        return (!$this->inicio || $this->inicio <= $now) &&
            (!$this->fin || $this->fin >= $now);
    }

    public function getDescuentoFormateadoAttribute()
    {
        return $this->tipo === 'porcentaje' ? "{$this->valor}%" : number_format($this->valor, 2) . "€";
    }
}
