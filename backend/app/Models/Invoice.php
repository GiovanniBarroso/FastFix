<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Order;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'fecha_emision',
        'numero_factura',
        'pdf_url',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
