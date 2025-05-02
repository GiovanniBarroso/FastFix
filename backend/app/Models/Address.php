<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Order;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calle',
        'numero',
        'ciudad',
        'provincia',
        'codigo_postal',
        'pais'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
