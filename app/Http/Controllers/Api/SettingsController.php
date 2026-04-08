<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ThemeSetting;

class SettingsController extends Controller
{
    public function index()
    {
        $all = ThemeSetting::all();

        // General settings as flat key→value
        $settings = $all->pluck('value', 'key');

        // Policy settings as a structured object
        $policyKeys = [
            'cod_charges', 'prepaid_charges', 'delivery_timeline',
            'return_policy', 'exchange_policy', 'refund_method',
            'extra_sections',
            'mega_deal_label', 'mega_deal_icon', 'mega_deal_badge',
            'mega_deal_bg_from', 'mega_deal_bg_to', 'mega_deal_text_color',
            'mega_deal_subtext_color',
        ];
        $generalKeys = [
            'store_name', 'store_email', 'support_phone', 'store_address',
            'default_currency', 'currency_symbol', 'time_zone', 'date_format',
            'weight_unit', 'length_unit',
        ];

        $policies = $all->whereIn('key', $policyKeys)->pluck('value', 'key');
        $general  = $all->whereIn('key', $generalKeys)->pluck('value', 'key');

        return response()->json(array_merge(
            $all->pluck('value', 'key')->toArray(),
            ['policies' => $policies, 'general' => $general]
        ));
    }
}
