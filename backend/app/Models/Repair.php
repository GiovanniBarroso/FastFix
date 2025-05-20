<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_type',
        'name',
        'problem_description',
        'status',
        'garantia',
        'repair_cost',
        'repair_notes',
        'received_at',
        'delivered_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
