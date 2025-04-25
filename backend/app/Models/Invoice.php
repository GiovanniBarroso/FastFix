<?php
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'asunto',
        'description',
        'estado',
        'fecha_emision',
        'user_id',
        'order_id'
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
?>