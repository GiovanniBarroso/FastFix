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
        'descripcion',
        'precio_base',   // 💡 Precio original sin descuento
        'precio',        // 💰 Precio final (con descuento aplicado)
        'stock',
        'activo',
        'category_id',
        'brand_id',
        'slug',
        'image'
    ];

    // Relaciones
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

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('cantidad', 'precio')
            ->withTimestamps();
    }

    public function carts()
    {
        return $this->belongsToMany(CartItem::class, 'shoppingcart_products')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    // 🔁 Método para aplicar descuentos activos al precio base
    public function aplicarDescuentos(): float
    {
        $precio = $this->precio_base;
        $ahora = now();

        $descuentosActivos = $this->discounts()
            ->where('activo', true)
            ->where(function ($q) use ($ahora) {
                $q->whereNull('inicio')->orWhere('inicio', '<=', $ahora);
            })
            ->where(function ($q) use ($ahora) {
                $q->whereNull('fin')->orWhere('fin', '>=', $ahora);
            })
            ->get();

        foreach ($descuentosActivos as $descuento) {
            if ($descuento->tipo === 'porcentaje') {
                $precio *= 1 - ($descuento->valor / 100);
            } elseif ($descuento->tipo === 'fijo') {
                $precio -= $descuento->valor;
            }
        }

        return max(0, round($precio, 2));
    }
}
