<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'attribute_value_id',
        'image_path',
        'media_type',
        'is_primary'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function getUrlAttribute()
    {
        if (str_starts_with($this->image_path, 'storage/')) {
            return asset($this->image_path);
        }
        return asset('storage/' . $this->image_path);
    }
}
