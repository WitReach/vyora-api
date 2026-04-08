@extends('layouts.admin')

@section('header', 'General Settings')

@section('content')
<form action="{{ route('admin.online-store.general-settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-8 pb-24">
        {{-- ── STORE INFORMATION ─────────────────────────── --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Store Information</h3>
            <p class="text-sm text-gray-500 mb-6">Basic details about your online store.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
                    <input type="text" name="store_name" value="{{ $settings['store_name'] }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Email</label>
                    <input type="email" name="store_email" value="{{ $settings['store_email'] }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Support Phone</label>
                    <input type="text" name="support_phone" value="{{ $settings['support_phone'] }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Store Address</label>
                    <textarea name="store_address" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">{{ $settings['store_address'] }}</textarea>
                </div>
            </div>
        </div>

        {{-- ── LOCALIZATION ──────────────────────────────── --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Localization</h3>
            <p class="text-sm text-gray-500 mb-6">Set your store's default currency and time preferences.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Default Currency</label>
                    <select name="default_currency"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        @foreach($currencies as $code => $name)
                            <option value="{{ $code }}" {{ $settings['default_currency'] == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol</label>
                    <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] }}"
                        placeholder="e.g. ₹, $"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Time Zone</label>
                    <select name="time_zone"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        @foreach($timezones as $tz)
                            <option value="{{ $tz['id'] }}" {{ $settings['time_zone'] == $tz['id'] ? 'selected' : '' }}>
                                {{ $tz['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
                    <select name="date_format"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="d/m/Y" {{ $settings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY (e.g. 28/03/2026)</option>
                        <option value="m/d/Y" {{ $settings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY (e.g. 03/28/2026)</option>
                        <option value="Y-m-d" {{ $settings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD (e.g. 2026-03-28)</option>
                        <option value="M j, Y" {{ $settings['date_format'] == 'M j, Y' ? 'selected' : '' }}>Month DD, YYYY (e.g. Mar 28, 2026)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ── STANDARDS & UNITS ─────────────────────────── --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Standards & Format</h3>
            <p class="text-sm text-gray-500 mb-6">Define the measurement systems for your products.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Weight Unit</label>
                    <select name="weight_unit"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="kg" {{ $settings['weight_unit'] == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                        <option value="g" {{ $settings['weight_unit'] == 'g' ? 'selected' : '' }}>Grams (g)</option>
                        <option value="lb" {{ $settings['weight_unit'] == 'lb' ? 'selected' : '' }}>Pounds (lb)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Length Unit</label>
                    <select name="length_unit"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="cm" {{ $settings['length_unit'] == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                        <option value="m" {{ $settings['length_unit'] == 'm' ? 'selected' : '' }}>Meters (m)</option>
                        <option value="in" {{ $settings['length_unit'] == 'in' ? 'selected' : '' }}>Inches (in)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ── STICKY SAVE BAR ──────────────────────────────── --}}
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-50 md:pl-64 flex items-center justify-between shadow-lg">
        <p class="text-sm text-gray-500">Global store settings will be applied immediately.</p>
        <button type="submit"
            class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 text-sm font-medium transition-colors">
            Save General Settings
        </button>
    </div>
</form>
@endsection
