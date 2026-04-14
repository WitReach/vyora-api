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
    public function uploadMasterPreview(Request $request, Product $product)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($product->preview_image) {
            $oldPath = base_path("../frontend-user/public/{$product->preview_image}");
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $relativePath = "uploads/products/preview"; // Use uploads for consistency

        $frontendPath = base_path("../frontend-user/public/{$relativePath}");
        $backendPath = public_path($relativePath);

        // Create directories
        if (!file_exists($frontendPath)) mkdir($frontendPath, 0755, true);
        if (!file_exists($backendPath)) mkdir($backendPath, 0755, true);

        // Move to frontend
        $file->move($frontendPath, $fileName);
        // Copy to backend
        copy($frontendPath . '/' . $fileName, $backendPath . '/' . $fileName);

        $product->update(['preview_image' => "/{$relativePath}/{$fileName}"]);

        return response()->json([
            'success' => true,
            'url' => asset($product->preview_image)
        ]);
    }

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
                $relativePath = "uploads/products/{$product->id}/colors/{$request->color_id}";
                $frontendPath = base_path("../frontend-user/public/{$relativePath}");
                $backendPath = public_path($relativePath);

                if (!file_exists($frontendPath)) mkdir($frontendPath, 0755, true);
                if (!file_exists($backendPath)) mkdir($backendPath, 0755, true);

                $file->move($frontendPath, $fileName);
                copy($frontendPath . '/' . $fileName, $backendPath . '/' . $fileName);

                $media = ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $request->color_id,
                    'image_path' => "/{$relativePath}/{$fileName}",
                    'media_type' => 'video',
                    'is_primary' => false
                ]);
            } else {
                // Handle image upload with WebP conversion
                $fileName = uniqid() . '.webp';
                $relativePath = "uploads/products/{$product->id}/colors/{$request->color_id}";
                $frontendPath = base_path("../frontend-user/public/{$relativePath}");
                $backendPath = public_path($relativePath);

                if (!file_exists($frontendPath)) mkdir($frontendPath, 0755, true);
                if (!file_exists($backendPath)) mkdir($backendPath, 0755, true);

                try {
                    // Save original first to frontend
                    $file->move($frontendPath, $fileName);
                    // Copy to backend
                    copy($frontendPath . '/' . $fileName, $backendPath . '/' . $fileName);
                    
                    // Optional WebP conversion
                    try {
                        $image = Image::read($backendPath . '/' . $fileName);
                        $image->toWebp(85)->save($backendPath . '/' . $fileName);
                        $image->toWebp(85)->save($frontendPath . '/' . $fileName);
                    } catch (\Exception $e) {
                        \Log::warning("WebP conversion failed: " . $e->getMessage());
                    }
                } catch (\Exception $e) {
                    \Log::error("Product media upload failed: " . $e->getMessage());
                    continue; // Skip this file
                }

                $media = ProductImage::create([
                    'product_id' => $product->id,
                    'color_id' => $request->color_id,
                    'image_path' => "/{$relativePath}/{$fileName}",
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
