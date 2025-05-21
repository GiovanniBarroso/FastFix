<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Role;
use App\Models\Address;
use App\Models\Favorite;
use App\Models\Shoppingcart;
use App\Models\Order;
use App\Models\Invoice;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'telefono',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Solo si usas Laravel 10+
        ];
    }

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // Relaciones
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function cart()
    {
        return $this->hasOne(Shoppingcart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

}
