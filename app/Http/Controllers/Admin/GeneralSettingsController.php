<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;
use Illuminate\Http\Request;

class GeneralSettingsController extends Controller
{
    const GROUP = 'general';

    const KEYS = [
        'store_name',
        'store_email',
        'support_phone',
        'store_address',
        'default_currency',
        'currency_symbol',
        'time_zone',
        'date_format',
        'weight_unit',
        'length_unit',
    ];

    public function index()
    {
        $rows = ThemeSetting::where('group', self::GROUP)->get()->keyBy('key');

        // Build a simple key→value array for the view
        $settings = collect(self::KEYS)->mapWithKeys(fn($k) => [$k => $rows->get($k)?->value ?? '']);

        $timezones = [];
        foreach (\DateTimeZone::listIdentifiers() as $tz) {
            $dt = new \DateTime('now', new \DateTimeZone($tz));
            $offsetSeconds = $dt->getOffset();
            $offsetLabel = $dt->format('P'); // e.g. +05:30
            $timezones[] = [
                'id' => $tz,
                'label' => "({$offsetLabel}) {$tz}",
                'offset' => $offsetSeconds
            ];
        }

        // Sort by offset, then by ID
        usort($timezones, function ($a, $b) {
            return $a['offset'] <=> $b['offset'] ?: strcmp($a['id'], $b['id']);
        });

        $currencies = [
            'INR' => 'Indian Rupee (₹)',
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'AUD' => 'Australian Dollar (A$)',
            'CAD' => 'Canadian Dollar (C$)',
            'JPY' => 'Japanese Yen (¥)',
            'AED' => 'UAE Dirham (د.إ)',
        ];

        return view('admin.general-settings.index', compact('settings', 'timezones', 'currencies'));
    }

    public function update(Request $request)
    {
        foreach (self::KEYS as $key) {
            ThemeSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key, ''), 'group' => self::GROUP]
            );
        }

        return redirect()->back()->with('success', 'General settings saved successfully.');
    }
}
