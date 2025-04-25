<?php
class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'description',
        'tipo',
        'valor',
        'fecha_inicio',
        'fecha_fin',
        'product_id',
        'activo'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

?>