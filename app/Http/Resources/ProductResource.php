<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $minPrice = $this->skus->min('price') ?? 0;
        $mrp = $this->skus->max('mrp') ?? 0;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'brand' => $this->brand_name,
            'product_type' => $this->productType?->name,
            
            // Global List Properties mapping securely
            'price' => (float) $minPrice,
            'price_formatted' => '₹' . number_format($minPrice),
            'mrp' => (float) $mrp,
            'discount_percentage' => ($mrp > $minPrice) ? round((($mrp - $minPrice) / $mrp) * 100) : 0,
            'image' => $this->image_url,
            'category' => $this->categories->first()?->name ?? 'General',
            'is_new' => $this->created_at->diffInDays(now()) < 7,

            // Categories
            'categories' => $this->categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug]),

            // Images
            'images' => $this->images->map(fn($img) => [
                'id' => $img->id,
                'url' => $img->url,
                'is_primary' => $img->is_primary,
                'color_id' => $img->color_id, // To filter images by selected color
            ]),

            // SKUs (Variants)
            // We grouping? Or sending flat list? Sending flat list is easier for frontend to find mathcing combo.
            // SKUs (Variants)
            'variants' => $this->skus->map(fn($sku) => [
                'id' => $sku->id,
                'code' => $sku->code,
                'price' => (float) $sku->price,
                'mrp' => (float) $sku->mrp,
                'stock' => $sku->stock,
                // Attributes for this SKU (e.g. Color: Red, Size: L)
                'attributes' => collect([
                    $sku->color ? [
                        'id' => $sku->color->id,
                        'name' => 'Color',
                        'value' => $sku->color->name,
                        'code' => $sku->color->name, // Using name as code for now, or hex if needed by frontend
                        'meta' => $sku->color->hex_code,
                    ] : null,
                    $sku->size ? [
                        'id' => $sku->size->id,
                        'name' => 'Size',
                        'value' => $sku->size->name,
                        'code' => $sku->size->code,
                        'meta' => null,
                    ] : null,
                ])->filter()->values(),
            ]),

            // SEO
            'seo' => [
                'title' => $this->seo_title,
                'description' => $this->seo_description,
            ],
        ];
    }
}
