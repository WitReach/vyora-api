<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // Calculate price range
        // Since a product has many SKUs, we show min_price or a range.
        $minPrice = $this->skus->min('price');
        $maxPrice = $this->skus->max('price');
        $mrp = $this->skus->max('mrp'); // Usually we show the highest MRP strike-through? Or lowest. Let's start simple.

        // Get hover image (from the color gallery)
        $hoverImage = $this->images->where('is_primary', true)->first() ?? $this->images->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'brand' => $this->brand_name,
            'price' => (float) $minPrice,
            'price_formatted' => '₹' . number_format($minPrice),
            'mrp' => (float) $mrp,
            // Calculate Discount %
            'discount_percentage' => ($mrp > $minPrice) ? round((($mrp - $minPrice) / $mrp) * 100) : 0,
            'image' => $this->image_url,
            'hover_image' => $hoverImage ? $hoverImage->url : null,
            'category' => $this->categories->first()?->name ?? 'General',
            'is_new' => $this->created_at->diffInDays(now()) < 7,
        ];
    }
}
