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
            // Assuming backend-admin and frontend-user are siblings
            $destinationPath = base_path('../frontend-user/public/uploads');

            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Convert to WebP and save
            try {
                // Use Intervention Image to read and encode
                $image = \Intervention\Image\Laravel\Facades\Image::read($file);
                $image->toWebp(80)->save($destinationPath . '/' . $filename);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Image processing failed: ' . $e->getMessage()], 500);
            }

            // Return the URL that the frontend will use to access the image
            // Since it's in frontend's public folder, we just return the relative path
            return response()->json([
                'url' => '/uploads/' . $filename,
                'success' => true
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
