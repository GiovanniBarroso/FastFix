<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Order;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'nombre',
        'direccion',
        'codigo_postal',
        'ciudad',
        'provincia',
        'pais',
        'telefono_envio',
        'principal',
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
