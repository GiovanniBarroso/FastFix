<?php
class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'activo'];

    public function products()
    {
        return $this->hasMany(Product::class, 'brands_id');
    }
}

?>