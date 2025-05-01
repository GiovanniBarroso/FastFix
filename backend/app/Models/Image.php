<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'alt_text', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
