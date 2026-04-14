@extends('layouts.admin')

@section('header', 'Brand Settings')

@section('content')
<div class="max-w-6xl mx-auto pb-24">
    <form action="{{ route('admin.online-store.theme-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Colors -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 border-b pb-4 mb-6">Visual Identity: Colors</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $primary = $settings->get('colors', collect())->where('key', 'primary_color')->first()->value ?? '#000000';
                    $secondary = $settings->get('colors', collect())->where('key', 'secondary_color')->first()->value ?? '#ffffff';
                    $accent = $settings->get('colors', collect())->where('key', 'accent_color')->first()->value ?? '#3b82f6';
                @endphp
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Primary Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="primary_color" value="{{ $primary }}" class="h-10 w-10 border rounded cursor-pointer">
                        <input type="text" value="{{ $primary }}" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm font-mono uppercase" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Secondary Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="secondary_color" value="{{ $secondary }}" class="h-10 w-10 border rounded cursor-pointer">
                        <input type="text" value="{{ $secondary }}" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm font-mono uppercase" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Accent Color</label>
                    <div class="flex items-center gap-2">
                        <input type="color" name="accent_color" value="{{ $accent }}" class="h-10 w-10 border rounded cursor-pointer">
                        <input type="text" value="{{ $accent }}" class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm font-mono uppercase" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Typography -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 border-b pb-4 mb-6">Typography</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Heading Font</label>
                    <select name="heading_font" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        @foreach($googleFonts as $font)
                            <option value="{{ $font }}" {{ ($settings->get('typography', collect())->where('key', 'heading_font')->first()->value ?? 'Inter') == $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Body Font</label>
                    <select name="body_font" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        @foreach($googleFonts as $font)
                            <option value="{{ $font }}" {{ ($settings->get('typography', collect())->where('key', 'body_font')->first()->value ?? 'Open Sans') == $font ? 'selected' : '' }}>{{ $font }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Logos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-bold text-gray-900 border-b pb-4 mb-6">Brand Assets (Logos)</h3>
            <div class="space-y-6">
                <!-- Main Logo -->
                <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="w-24 h-24 bg-white border rounded flex items-center justify-center overflow-hidden" id="preview-container-main_logo">
                        @if($logo = ($settings->get('logos', collect())->where('key', 'main_logo')->first() ?? null))
                            <img src="{{ asset($logo->value) }}" class="max-w-full max-h-full object-contain" id="img-main_logo">
                        @else
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-[10px] text-gray-400 font-bold uppercase">No Logo</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Upload Main Logo</label>
                        <input type="file" name="logos[main_logo]" onchange="previewImage(this, 'main_logo')" class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">
                    </div>
                </div>

                <!-- Favicon -->
                <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-white border rounded flex items-center justify-center overflow-hidden" id="preview-container-favicon">
                        @if($favicon = ($settings->get('logos', collect())->where('key', 'favicon')->first() ?? null))
                            <img src="{{ asset($favicon->value) }}" class="max-w-full max-h-full object-contain" id="img-favicon">
                        @else
                            <span class="text-[10px] text-gray-400 font-bold uppercase">Fav</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Upload Favicon</label>
                        <input type="file" name="logos[favicon]" onchange="previewImage(this, 'favicon')" class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Save -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-50 md:pl-64 flex justify-end">
            <button type="submit" class="bg-black text-white px-8 py-2 rounded-md font-bold text-sm hover:bg-gray-800 transition-colors shadow-lg">
                Update Theme Settings
            </button>
        </div>
    </form>
</div>
@push('scripts')
<script>
    function previewImage(input, type) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById(`preview-container-${type}`);
                let img = document.getElementById(`img-${type}`);
                
                if (!img) {
                    container.innerHTML = `<img src="${e.target.result}" class="max-w-full max-h-full object-contain" id="img-${type}">`;
                } else {
                    img.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection