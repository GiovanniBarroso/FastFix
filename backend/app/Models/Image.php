<?php
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'alt_text', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

?>