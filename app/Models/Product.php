<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->preview_image) return null;
        if (str_starts_with($this->preview_image, 'storage/')) {
            return asset($this->preview_image);
        }
        return asset('storage/' . $this->preview_image);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product');
    }

    public function sizeChart()
    {
        return $this->belongsToMany(SizeChart::class, 'product_size_chart');
    }
}
