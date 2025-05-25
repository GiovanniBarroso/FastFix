<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_type',
        'nombre',
        'problem_description',
        'status',
        'garantia',
        'fecha_garantia',
        'repair_cost',
        'repair_notes',
        'received_at',
        'delivered_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Getter para calcular fecha fin de garantía
    public function getFechaFinGarantiaAttribute()
    {
        if (!$this->fecha_garantia || $this->garantia === 'sin') {
            return null;
        }

        $meses = match ($this->garantia) {
            '3m' => 3,
            '6m' => 6,
            default => 0,
        };

        return Carbon::parse($this->fecha_garantia)->addMonths($meses);
    }
}
