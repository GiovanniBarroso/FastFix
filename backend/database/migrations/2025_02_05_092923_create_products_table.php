<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'description',
        'precio',
        'stock',
        'activo',
        'categories_id',
        'brands_id',
        'image'
    ];

    // Relaciones
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
;
