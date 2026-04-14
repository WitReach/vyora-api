<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';

            // Store in frontend-user/public/uploads
            $destinationPath = base_path('../frontend-user/public/uploads');
            $backendPath = public_path('uploads');

            // Create directories if not exists
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0755, true);
            if (!file_exists($backendPath)) mkdir($backendPath, 0755, true);

            try {
                // First move to frontend
                $file->move($destinationPath, $filename);
                
                // Then copy to backend
                copy($destinationPath . '/' . $filename, $backendPath . '/' . $filename);

                // Try to convert to webp if it's not already (Optional, don't fail if processing fails)
                try {
                    $img = \Intervention\Image\Laravel\Facades\Image::read($backendPath . '/' . $filename);
                    $img->toWebp(80)->save($backendPath . '/' . $filename);
                    $img->toWebp(80)->save($destinationPath . '/' . $filename);
                } catch (\Exception $e) {
                    \Log::warning("WebP conversion failed for CMS upload: " . $e->getMessage());
                }

            } catch (\Exception $e) {
                \Log::error("CMS Upload failed: " . $e->getMessage());
                return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
            }

            return response()->json([
                'url' => '/uploads/' . $filename,
                'success' => true
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
