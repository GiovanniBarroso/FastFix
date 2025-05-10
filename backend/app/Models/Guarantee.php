<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'fecha_inicio',
        'fecha_fin'
    ];

    // Relación con el usuario dueño de la garantía
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el producto cubierto por la garantía
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
