<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'activo'];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id'); // Asegúrate que esta sea la FK real
    }
}
