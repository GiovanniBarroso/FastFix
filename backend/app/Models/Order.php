<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Address;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id', // 👈 NECESARIO
        'total',
        'estado',
        'metodo_pago',
        'paypal_payment_id',
        'paypal_status',
        'fecha_pago',
        'fecha_pedido',
        'notas_cliente',
        'notas_admin',
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

}
