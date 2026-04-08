<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeSettingsController extends Controller
{
    public function index()
    {
        $settings = \App\Models\ThemeSetting::all()->groupBy('group');
        
        $googleFonts = \Illuminate\Support\Facades\Cache::remember('google_fonts_list', now()->addDays(7), function () {
            try {
                $response = \Illuminate\Support\Facades\Http::get('https://gwfh.mranftl.com/api/fonts');
                if ($response->successful()) {
                    return collect($response->json())
                        ->pluck('family')
                        ->sort()
                        ->values()
                        ->toArray();
                }
            } catch (\Exception $e) {
                // Ignore and fall back to defaults
            }
            return ['Inter', 'Roboto', 'Open Sans', 'Montserrat', 'Playfair Display'];
        });

        return view('admin.theme-settings.index', compact('settings', 'googleFonts'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method', 'logos');

        // Update basic settings
        foreach ($data as $key => $value) {
            \App\Models\ThemeSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $this->getGroupForKey($key)
                ]
            );
        }

        // Handle File Uploads (Logos)
        if ($request->hasFile('logos')) {
            foreach ($request->file('logos') as $key => $file) {
                // Determine destination
                $fileName = time() . '_' . $key . '.' . $file->getClientOriginalExtension();
                $relativePath = "storage/theme/logos";
                $destinationPath = base_path("../frontend-user/public/{$relativePath}");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
                $finalPath = "{$relativePath}/{$fileName}";

                \App\Models\ThemeSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $finalPath,
                        'group' => 'logos'
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Theme settings updated successfully.');
    }

    private function getGroupForKey($key)
    {
        if (str_starts_with($key, 'mega_deal_'))
            return 'mega_deal';
        if (str_contains($key, 'color'))
            return 'colors';
        if (str_contains($key, 'font'))
            return 'typography';
        if (str_starts_with($key, 'social_'))
            return 'social';
        if (str_starts_with($key, 'contact_'))
            return 'contact';
        if (str_starts_with($key, 'store_'))
            return 'store_info';
        if (str_contains($key, 'layout'))
            return 'layout';
        
        return 'general';
    }
}
