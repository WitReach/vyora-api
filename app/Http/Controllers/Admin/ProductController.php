<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with('skus')->latest()->paginate(10);
        
        $stats = [
            'total' => \App\Models\Product::count(),
            'active' => \App\Models\Product::where('is_active', true)->count(),
            'low_stock' => \App\Models\Sku::where('stock', '<=', 5)->count(),
            'out_of_stock' => \App\Models\Sku::where('stock', 0)->count(),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $products = \App\Models\Product::where('name', 'like', "%{$query}%")
            ->select('id', 'name', 'preview_image')
            ->limit(20)
            ->get();

        // Transform image URL
        $products->transform(function ($product) {
            $product->image_url = $product->preview_image ? '/' . $product->preview_image : null;
            return $product;
        });

        return response()->json($products);
    }

    public function create()
    {
        $categories = \App\Models\Category::whereNull('parent_id')->with('children')->get();
        $collections = \App\Models\Collection::where('is_active', true)->get();
        $productTypes = \App\Models\ProductType::all();
        $sizeCharts = \App\Models\SizeChart::where('is_active', true)->orderBy('name')->get();
        $colors = \App\Models\Color::orderBy('name')->get();
        $sizes = \App\Models\Size::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'collections', 'productTypes', 'sizeCharts', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        // Enforce slug formatting
        $request->merge([
            'slug' => \Illuminate\Support\Str::slug($request->slug ?? $request->name)
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
        ]);

        // Create product
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'brand_name' => $request->brand_name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'product_type_id' => $request->product_type_id,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_keywords' => $request->seo_keywords,
            'is_active' => false, // Products are inactive by default until admin activates
            'is_returnable' => $request->has('is_returnable'),
            'on_sale' => $request->has('on_sale'),
        ];

        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            $file = $request->file('preview_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $relativePath = "storage/products/preview";
            $destinationPath = base_path("../frontend-user/public/{$relativePath}");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);
            $data['preview_image'] = "{$relativePath}/{$fileName}";
        }

        $product = \App\Models\Product::create($data);

        // Sync associations
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('collections')) {
            $product->collections()->sync($request->collections);
        }

        if ($request->filled('size_chart_id')) {
            $product->sizeChart()->sync([$request->size_chart_id]);
        }

        // Create new SKUs if provided
        if ($request->has('new_skus')) {
            foreach ($request->new_skus as $newSku) {
                if (!empty($newSku['code']) && isset($newSku['stock'])) {
                    $sizeId = null;
                    if (!empty($newSku['size'])) {
                        $size = \App\Models\Size::firstOrCreate(
                            ['name' => trim($newSku['size'])],
                            ['code' => strtoupper(trim($newSku['size']))]
                        );
                        $sizeId = $size->id;
                    }

                    $product->skus()->create([
                        'code' => $newSku['code'],
                        'price' => $newSku['price'] ?: 0,
                        'stock' => $newSku['stock'],
                        'color_id' => $newSku['color_id'] ?: null,
                        'size_id' => $sizeId,
                    ]);
                }
            }
        }

        $tab = $request->input('redirect_tab', 'info');
        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product created successfully')
            ->withFragment($tab);
    }

    public function edit(\App\Models\Product $product)
    {
        $product->load([
            'skus.color',
            'skus.size',
            'categories',
            'collections',
            'images' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            },
            'images.color',
            'productType'
        ]);

        $categories = \App\Models\Category::whereNull('parent_id')->with('children')->get();
        $collections = \App\Models\Collection::where('is_active', true)->get();
        $productTypes = \App\Models\ProductType::all();

        // Get unique colors from product SKUs
        $productColors = $product->skus->pluck('color')->unique('id')->filter();

        // Group images by color_id
        $mediaByColor = $product->images->groupBy('color_id');

        // Get all active size charts
        $sizeCharts = \App\Models\SizeChart::where('is_active', true)->orderBy('name')->get();

        // Get available attributes for new variants
        $colors = \App\Models\Color::orderBy('name')->get();
        $sizes = \App\Models\Size::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'collections', 'productTypes', 'productColors', 'mediaByColor', 'sizeCharts', 'colors', 'sizes'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
        // Enforce slug formatting
        $request->merge([
            'slug' => \Illuminate\Support\Str::slug($request->slug)
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'skus' => 'nullable|array',
            'skus.*.code' => 'required|string|max:255',
            'skus.*.price' => 'required|numeric|min:0',
            'skus.*.stock' => 'required|integer|min:0',
        ]);

        // Update basic product details
        // Update basic product details
        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'brand_name' => $request->brand_name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'product_type_id' => $request->product_type_id,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_keywords' => $request->seo_keywords,
            'is_active' => $request->has('is_active'),
            'is_returnable' => $request->has('is_returnable'),
            'on_sale' => $request->has('on_sale'),
        ];

        // Handle Master Image Upload
        if ($request->hasFile('preview_image')) {
            $request->validate([
                'preview_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // Delete old image if exists
            if ($product->preview_image) {
                $oldPath = base_path("../frontend-user/public/{$product->preview_image}");
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('preview_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $relativePath = "storage/products/preview";
            $destinationPath = base_path("../frontend-user/public/{$relativePath}");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);
            $data['preview_image'] = "{$relativePath}/{$fileName}";
        } elseif ($request->file('preview_image') && !$request->file('preview_image')->isValid()) {
            return redirect()->back()
                ->withInput()
                ->withFragment($request->input('redirect_tab', 'media'))
                ->withErrors(['preview_image' => 'Upload failed: ' . $request->file('preview_image')->getErrorMessage()]);
        }

        $product->update($data);

        // Sync Associations
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        } else {
            $product->categories()->detach();
        }

        if ($request->has('collections')) {
            $product->collections()->sync($request->collections);
        } else {
            $product->collections()->detach();
        }

        // Sync Size Chart (one product can have only one size chart)
        if ($request->filled('size_chart_id')) {
            $product->sizeChart()->sync([$request->size_chart_id]);
        } else {
            $product->sizeChart()->detach();
        }

        // Update SKUs
        if ($request->has('skus')) {
            foreach ($request->skus as $skuId => $skuData) {
                // Ensure we only update SKUs belonging to this product
                $sku = $product->skus()->find($skuId);
                if ($sku) {
                    $sku->update([
                        'code' => $skuData['code'],
                        'price' => $skuData['price'],
                        'stock' => $skuData['stock'],
                    ]);
                }
            }
        }

        // Create new SKUs
        if ($request->has('new_skus')) {
            foreach ($request->new_skus as $newSku) {
                // Validate basic required fields for a new SKU
                if (!empty($newSku['code']) && isset($newSku['stock'])) {
                    // Handle manual size entry - find or create the size
                    $sizeId = null;
                    if (!empty($newSku['size'])) {
                        $size = \App\Models\Size::firstOrCreate(
                            ['name' => trim($newSku['size'])],
                            ['code' => strtoupper(trim($newSku['size']))]
                        );
                        $sizeId = $size->id;
                    }

                    $product->skus()->create([
                        'code' => $newSku['code'],
                        'price' => $newSku['price'] ?: 0,
                        'stock' => $newSku['stock'],
                        'color_id' => $newSku['color_id'] ?: null,
                        'size_id' => $sizeId,
                    ]);
                }
            }
        }

        $tab = $request->input('redirect_tab', 'info');
        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Product updated successfully')
            ->withFragment($tab);
    }
    public function destroy(\App\Models\Product $product)
    {
        // Check if product has any orders
        // Assuming relationship or direct query. Let's use direct query to be safe if relation is missing.
        $hasOrders = \Illuminate\Support\Facades\DB::table('order_items')->where('product_id', $product->id)->exists();

        if ($hasOrders) {
            return back()->with('error', 'Cannot delete product: There are existing purchases associated with it.');
        }

        // Proceed to delete
        // Detach relations first if needed, but cascade usually handles it.
        // Explicitly ensuring SKUs are handled if cascade is missing, but migration said cascade.
        // Let's just delete the product.
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
