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

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brands_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('cantidad', 'precio')->withTimestamps();
    }

    public function carts()
    {
        return $this->belongsToMany(Shoppingcart::class, 'shoppingcart_products')
            ->withPivot('quantity', 'precio_unitario')->withTimestamps();
    }
}



?>