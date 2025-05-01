<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Product;
use App\Models\Voucher;

class Shoppingcart extends Model
{
    use HasFactory;

    protected $table = 'shoppingcart'; // ✅ Verifica que tu tabla realmente se llama así

    protected $fillable = ['fecha_creacion', 'estado', 'user_id', 'voucher_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shoppingcart_products')
            ->withPivot('quantity', 'precio_unitario')
            ->withTimestamps();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
