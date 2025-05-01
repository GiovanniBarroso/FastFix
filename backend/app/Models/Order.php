<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Address;
use App\Models\Voucher;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_pedido',
        'estado',
        'total',
        'address_id',
        'user_id',
        'voucher_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('cantidad', 'precio')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
