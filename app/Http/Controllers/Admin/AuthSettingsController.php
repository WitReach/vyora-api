<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AuthSettingsController extends Controller
{
    const GROUP = 'auth_settings';

    public function index()
    {
        $rows = ThemeSetting::where('group', self::GROUP)->get()->keyBy('key');

        // Defaults
        $settings = [
            'auth_fields' => json_decode($rows->get('auth_fields')?->value ?? '{"name":{"visible":true,"required":true,"auth_type":"data_entry"},"email":{"visible":true,"required":true,"auth_type":"data_entry"},"phone":{"visible":true,"required":false,"auth_type":"data_entry"}}', true),
            'auth_social' => json_decode($rows->get('auth_social')?->value ?? '{"google":{"enabled":false,"client_id":""},"facebook":{"enabled":false,"client_id":""}}', true),
            'auth_appearance' => json_decode($rows->get('auth_appearance')?->value ?? '{"ux_mode":"page","border_radius":"16","border_color":"#e5e7eb"}', true),
            'auth_header' => json_decode($rows->get('auth_header')?->value ?? '{"text":"Welcome Back","image":"","order":["image","text"],"image_width":"120"}', true),
            'auth_footer' => json_decode($rows->get('auth_footer')?->value ?? '{"text":"Secure payment powered by Dope Style","image":"","order":["text"],"image_width":"80"}', true),
        ];

        // Fetch brand settings for the preview
        $brandRows = ThemeSetting::where('group', 'typography')->orWhere('group', 'colors')->get()->keyBy('key');
        $brand = [
            'heading_font' => $brandRows->get('heading_font')?->value ?? 'Inter',
            'primary_color' => $brandRows->get('primary_color')?->value ?? '#000000',
        ];

        return view('admin.auth-settings.index', compact('settings', 'brand'));
    }

    public function update(Request $request)
    {
        $data = $request->all();

        // Handle JSON fields
        $jsonFields = ['auth_methods', 'auth_fields', 'auth_social', 'auth_appearance', 'auth_header', 'auth_footer'];

        foreach ($jsonFields as $field) {
            if ($request->has($field)) {
                $newValue = $request->input($field);
                
                // Fetch existing to merge (important for preserving image paths)
                $existing = ThemeSetting::where('key', $field)->first();
                $existingVal = json_decode($existing?->value ?? '{}', true);
                
                $finalValue = array_merge($existingVal, is_array($newValue) ? $newValue : []);

                ThemeSetting::updateOrCreate(
                    ['key' => $field],
                    ['value' => json_encode($finalValue), 'group' => self::GROUP]
                );
            }
        }

        // Handle Image Uploads for Header/Footer
        $this->handleImageUpload($request, 'auth_header_image', 'auth_header');
        $this->handleImageUpload($request, 'auth_footer_image', 'auth_footer');

        return redirect()->back()->with('success', 'Auth settings updated successfully.');
    }

    private function handleImageUpload(Request $request, $fileKey, $settingKey)
    {
        if ($request->hasFile($fileKey)) {
            $file = $request->file($fileKey);
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'uploads/auth/' . $filename;

            // Save to backend public
            $file->move(public_path('uploads/auth'), $filename);

            // Mirror to frontend public
            $frontendPath = base_path('../frontend-user/public/uploads/auth');
            if (!File::exists($frontendPath)) {
                File::makeDirectory($frontendPath, 0755, true);
            }
            File::copy(public_path($path), $frontendPath . '/' . $filename);

            // Update JSON setting
            $setting = ThemeSetting::where('key', $settingKey)->first();
            $val = json_decode($setting?->value ?? '{}', true);
            $val['image'] = '/' . $path;
            
            ThemeSetting::updateOrCreate(
                ['key' => $settingKey],
                ['value' => json_encode($val), 'group' => self::GROUP]
            );
        }
    }
}
