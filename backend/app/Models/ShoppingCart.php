<?php
class Shoppingcart extends Model
{
    use HasFactory;

    protected $table = 'shoppingcart';

    protected $fillable = ['fecha_creacion', 'estado', 'user_id', 'voucher_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shoppingcart_products')
            ->withPivot('quantity', 'precio_unitario')->withTimestamps();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}

?>