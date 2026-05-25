<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SearchQuery;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');

        // Use Scout's search, which will use Algolia if configured, or Database if not
        $products = Product::search($query)
            ->query(function ($builder) {
                // Eager load related data and apply any necessary constraints
                $builder->with(['images', 'skus'])
                        ->where('is_active', true);
            })
            ->paginate(12);

        // Record the search if there's a valid query string
        if (!empty(trim($query))) {
            SearchQuery::create([
                'query' => trim($query),
                'results_count' => $products->total(),
            ]);
        }

        return response()->json($products);
    }
}
