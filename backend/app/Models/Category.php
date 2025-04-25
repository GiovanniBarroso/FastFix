<?php
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'description', 'activo'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }
}


?>