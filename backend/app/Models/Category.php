<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'activo'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); // Asegúrate que esta FK sea la correcta
    }
}
