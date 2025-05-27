<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_items';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // En CartItem.php
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
