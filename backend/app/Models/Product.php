<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Favorite;
use App\Models\Image;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Shoppingcart;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'description',
        'precio',
        'stock',
        'activo',
        'category_id',
        'brand_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
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
            ->withPivot('cantidad', 'precio')
            ->withTimestamps();
    }

    public function carts()
    {
        return $this->belongsToMany(Shoppingcart::class, 'shoppingcart_products')
            ->withPivot('quantity', 'precio_unitario')
            ->withTimestamps();
    }
}
