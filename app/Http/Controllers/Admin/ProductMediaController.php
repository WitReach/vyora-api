<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductMediaController extends Controller
{
    public function upload(Request $request, Product $product)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpeg,jpg,png,webp,mp4,mov,avi|max:51200', // 50MB max
            'color_id' => 'required|exists:colors,id'
        ]);

        $uploadedMedia = [];

        foreach ($request->file('files') as $file) {
            $extension = $file->getClientOriginalExtension();
            $isVideo = in_array(strtolower($extension), ['mp4', 'mov', 'avi']);

            if ($isVideo) {
                // Handle video upload
                $fileName = uniqid() . '.' . $extension;
                $relativePath = "storage/products/{$product->id}/colors/{$request->color_id}";
                $destinationPath = base_path("../frontend-user/public/{$relativePath}");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);

                $media = ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $request->color_id,
                    'image_path' => "{$relativePath}/{$fileName}",
                    'media_type' => 'video',
                    'is_primary' => false
                ]);
            } else {
                // Handle image upload with WebP conversion
                $fileName = uniqid() . '.webp';
                $relativePath = "storage/products/{$product->id}/colors/{$request->color_id}";
                $destinationPath = base_path("../frontend-user/public/{$relativePath}");

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Convert to WebP
                $image = Image::read($file);
                $image->toWebp(85)->save("{$destinationPath}/{$fileName}");

                $media = ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $request->color_id,
                    'image_path' => "{$relativePath}/{$fileName}",
                    'media_type' => 'image',
                    'is_primary' => false
                ]);
            }

            $uploadedMedia[] = [
                'id' => $media->id,
                'url' => $media->url,
                'media_type' => $media->media_type,
                'is_primary' => $media->is_primary
            ];
        }

        return response()->json([
            'success' => true,
            'media' => $uploadedMedia
        ]);
    }

    public function delete(Product $product, ProductImage $productImage)
    {
        // Ensure the image belongs to the product
        if ($productImage->product_id !== $product->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete file from storage
        $fullPath = base_path("../frontend-user/public/{$productImage->image_path}");
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Delete database record
        $productImage->delete();

        return response()->json(['success' => true]);
    }

    public function setPrimary(Product $product, ProductImage $productImage)
    {
        // Ensure the image belongs to the product
        if ($productImage->product_id !== $product->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Unset all primary images for this product and color
        ProductImage::where('product_id', $product->id)
            ->where('color_id', $productImage->color_id)
            ->update(['is_primary' => false]);

        // Set this image as primary
        $productImage->update(['is_primary' => true]);

        return response()->json(['success' => true]);
    }

    public function reorder(Request $request, Product $product)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:product_images,id',
            'order.*.sort_order' => 'required|integer'
        ]);

        foreach ($request->order as $item) {
            ProductImage::where('id', $item['id'])
                ->where('product_id', $product->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
