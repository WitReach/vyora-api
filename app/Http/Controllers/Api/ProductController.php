<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['skus', 'images', 'categories']);

        if ($request->has('slugs')) {
            $slugs = explode(',', $request->slugs);
            $query->whereIn('slug', $slugs);
            // Optional: order by given slugs
            if (!empty($slugs)) {
                $orderByRaw = "CASE slug ";
                foreach ($slugs as $index => $slug) {
                    $orderByRaw .= "WHEN '" . addslashes($slug) . "' THEN $index ";
                }
                $orderByRaw .= "ELSE " . count($slugs) . " END";
                $query->orderByRaw($orderByRaw);
            }
        } else {
            $query->latest();
        }

        $limit = $request->input('limit', 20);
        $products = $query->paginate($limit);

        return ProductListResource::collection($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['skus.attributeValues.attribute', 'images', 'categories', 'productType'])
            ->firstOrFail();

        return new ProductResource($product);
    }
}
