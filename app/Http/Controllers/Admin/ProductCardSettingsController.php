<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class ProductCardSettingsController extends Controller
{
    /**
     * Display the product card settings interface.
     */
    public function index()
    {
        $keys = [
            'pc_style',
            'pc_bg_color',
            'pc_border_radius',
            'pc_shadow',
            'pc_btn_layout',
            'pc_show_wishlist',
            'pc_image_aspect'
        ];

        // Fetch all existing product card settings
        $settingsRaw = ThemeSetting::whereIn('key', $keys)->get();
        $settings = $settingsRaw->pluck('value', 'key')->toArray();

        // Ensure defaults are populated if missing
        $defaults = [
            'pc_style' => 'lift',
            'pc_bg_color' => '#ffffff',
            'pc_border_radius' => 'rounded',
            'pc_shadow' => 'soft',
            'pc_btn_layout' => 'both',
            'pc_show_wishlist' => 'true',
            'pc_image_aspect' => 'aspect-[4/5]',
        ];

        $settings = array_merge($defaults, $settings);

        return view('admin.product-card-settings.index', compact('settings'));
    }

    /**
     * Update the product card settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'pc_style' => 'nullable|string',
            'pc_bg_color' => 'nullable|string',
            'pc_border_radius' => 'nullable|string',
            'pc_shadow' => 'nullable|string',
            'pc_btn_layout' => 'nullable|string',
            'pc_show_wishlist' => 'nullable|string',
            'pc_image_aspect' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            ThemeSetting::updateOrCreate(
                ['group' => 'product_card', 'key' => $key],
                ['value' => $value ?? '']
            );
        }

        return redirect()->back()->with('success', 'Product Card settings updated successfully!');
    }
}
