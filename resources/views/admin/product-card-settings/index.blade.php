@extends('layouts.admin')

@section('title', 'Product Card Settings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Product Card Designer</h1>
            <p class="mt-2 text-sm text-gray-600">Customize the appearance of product cards across your entire store.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl bg-green-50 p-4 border border-green-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.online-store.product-card-settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Configuration -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Card Style -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 border-b pb-4 mb-4">Card Layout & Surface</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hover Animation / Outline</label>
                            <select name="pc_style" id="pc_style" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="lift" {{ $settings['pc_style'] === 'lift' ? 'selected' : '' }}>Hover Lift (Pops up)</option>
                                <option value="outline" {{ $settings['pc_style'] === 'outline' ? 'selected' : '' }}>Thin Outline</option>
                                <option value="solid" {{ $settings['pc_style'] === 'solid' ? 'selected' : '' }}>Flat Solid Surface</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="pc_bg_color" id="pc_bg_color" value="{{ $settings['pc_bg_color'] }}" class="h-10 w-16 cursor-pointer rounded border border-gray-200 block bg-white">
                                <span class="text-xs text-gray-500 font-mono" id="bg-color-label">{{ $settings['pc_bg_color'] }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Border Radius</label>
                            <select name="pc_border_radius" id="pc_border_radius" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="rounded" {{ $settings['pc_border_radius'] === 'rounded' ? 'selected' : '' }}>Rounded (Standard)</option>
                                <option value="pill" {{ $settings['pc_border_radius'] === 'pill' ? 'selected' : '' }}>Ultra Rounded (Pill-like)</option>
                                <option value="square" {{ $settings['pc_border_radius'] === 'square' ? 'selected' : '' }}>Sharp Corners (Square)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shadow Intensity</label>
                            <select name="pc_shadow" id="pc_shadow" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="soft" {{ $settings['pc_shadow'] === 'soft' ? 'selected' : '' }}>Soft Subtle Shadow</option>
                                <option value="strong" {{ $settings['pc_shadow'] === 'strong' ? 'selected' : '' }}>Strong Elevated Shadow</option>
                                <option value="none" {{ $settings['pc_shadow'] === 'none' ? 'selected' : '' }}>No Shadow</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Content Options -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 border-b pb-4 mb-4">Buttons & Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Call To Action Button</label>
                            <select name="pc_btn_layout" id="pc_btn_layout" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="text_only" {{ $settings['pc_btn_layout'] === 'text_only' ? 'selected' : '' }}>Text Only (Buy Now)</option>
                                <option value="icon_only" {{ $settings['pc_btn_layout'] === 'icon_only' ? 'selected' : '' }}>Icon Only</option>
                                <option value="both" {{ $settings['pc_btn_layout'] === 'both' ? 'selected' : '' }}>Icon + Text</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Wishlist Button</label>
                            <select name="pc_show_wishlist" id="pc_show_wishlist" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="true" {{ $settings['pc_show_wishlist'] === 'true' ? 'selected' : '' }}>Show Wishlist Pattern</option>
                                <option value="false" {{ $settings['pc_show_wishlist'] === 'false' ? 'selected' : '' }}>Hide</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image Aspect Ratio</label>
                            <select name="pc_image_aspect" id="pc_image_aspect" class="block w-full rounded-xl border border-gray-300 py-2.5 px-3 focus:ring-black focus:border-black sm:text-sm">
                                <option value="aspect-[4/5]" {{ $settings['pc_image_aspect'] === 'aspect-[4/5]' ? 'selected' : '' }}>Portrait (4:5)</option>
                                <option value="aspect-square" {{ $settings['pc_image_aspect'] === 'aspect-square' ? 'selected' : '' }}>Square (1:1)</option>
                                <option value="aspect-[3/4]" {{ $settings['pc_image_aspect'] === 'aspect-[3/4]' ? 'selected' : '' }}>Tall Portrait (3:4)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-black text-white px-6 py-2.5 rounded-xl font-semibold shadow-sm hover:bg-gray-800 transition">Save Global Design</button>
                </div>
            </div>

            <!-- Right Side: Live Preview -->
            <div class="lg:col-span-4">
                <div class="sticky top-6">
                    <h3 class="text-base font-bold leading-7 text-gray-900 mb-4">Live Preview</h3>
                    
                    <!-- Preview Container -->
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 flex items-center justify-center min-h-[500px]">
                        
                        <!-- THE FAKE REACT CARD -->
                        <div id="preview-card" class="w-full max-w-[280px] bg-white rounded-2xl p-3 border shadow-[0_4px_20px_rgb(0,0,0,0.04)] transition-all duration-300">
                            <!-- Image -->
                            <div id="preview-aspect" class="block relative aspect-[4/5] bg-gray-100 overflow-hidden rounded-xl flex items-center justify-center">
                                <span class="bg-black text-white text-[10px] absolute top-3 left-3 px-2 py-1 rounded-full uppercase font-bold tracking-wider">New</span>
                                <svg class="w-10 h-10 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm3 3h6v2H9V9zm0 4h6v2H9v-2z"></path></svg>
                            </div>

                            <!-- Text Content -->
                            <div class="mt-4 px-1 pb-1 flex flex-col gap-1">
                                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">BRAND</span>
                                <h3 class="text-sm font-medium text-gray-900 mt-0.5">Premium Graphic Tee</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-400 font-medium line-through">₹1,999</span>
                                    <span class="text-base font-extrabold text-gray-900">₹1,499</span>
                                    <span class="text-[10px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded ml-auto">25% OFF</span>
                                </div>
                                <div class="text-[11px] text-gray-500 mt-1 font-medium bg-green-50/50 p-1.5 rounded-md border border-green-100/50 leading-tight">
                                    Best Price <span class="text-green-700 font-bold">₹1,199</span> with coupon
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 mt-3 pt-2">
                                    <button id="preview-main-btn" class="flex-1 bg-black text-white text-xs font-bold uppercase py-2.5 rounded-lg flex items-center justify-center gap-2">
                                        <svg id="preview-btn-icon" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                        <span id="preview-btn-text">Buy Now</span>
                                    </button>
                                    <button id="preview-wishlist-btn" class="w-9 h-9 flex shrink-0 items-center justify-center border border-gray-200 text-gray-400 rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const card = document.getElementById('preview-card');
        const aspectBox = document.getElementById('preview-aspect');
        const mainBtn = document.getElementById('preview-main-btn');
        const btnIcon = document.getElementById('preview-btn-icon');
        const btnText = document.getElementById('preview-btn-text');
        const wishlistBtn = document.getElementById('preview-wishlist-btn');

        const inputs = {
            style: document.getElementById('pc_style'),
            bgColor: document.getElementById('pc_bg_color'),
            bgLabel: document.getElementById('bg-color-label'),
            radius: document.getElementById('pc_border_radius'),
            shadow: document.getElementById('pc_shadow'),
            btnLayout: document.getElementById('pc_btn_layout'),
            wishlist: document.getElementById('pc_show_wishlist'),
            aspect: document.getElementById('pc_image_aspect')
        };

        function updatePreview() {
            // Apply Bg Color
            card.style.backgroundColor = inputs.bgColor.value;
            inputs.bgLabel.textContent = inputs.bgColor.value;

            // Reset specific tailwind classes for replacement
            card.classList.remove('rounded-none', 'rounded-2xl', 'rounded-[2rem]', 'border-gray-100', 'border-gray-200', 'shadow-sm', 'shadow-md', 'shadow-lg', 'shadow-[0_4px_20px_rgb(0,0,0,0.04)]', 'hover:-translate-y-1', 'hover:-translate-y-1.5', 'border-transparent');
            aspectBox.classList.remove('rounded-none', 'rounded-xl', 'rounded-[1.75rem]');
            aspectBox.classList.remove('aspect-[4/5]', 'aspect-square', 'aspect-[3/4]');

            // Apply Radius
            if (inputs.radius.value === 'square') {
                card.classList.add('rounded-none');
                aspectBox.classList.add('rounded-none');
            } else if (inputs.radius.value === 'pill') {
                card.classList.add('rounded-[2rem]');
                aspectBox.classList.add('rounded-[1.75rem]');
            } else {
                card.classList.add('rounded-2xl');
                aspectBox.classList.add('rounded-xl');
            }

            // Apply Aspect
            aspectBox.classList.add(inputs.aspect.value);

            // Apply Borders & Shadows
            let style = inputs.style.value;
            let shadow = inputs.shadow.value;

            if (style === 'outline') {
                card.classList.add('border-gray-200');
            } else if (style === 'solid') {
                card.classList.add('border-gray-100');
            } else { // lift
                card.classList.add('border-gray-100');
            }

            // Shadows logic
            if (style === 'lift') {
                card.classList.add('hover:-translate-y-1');
                if (shadow === 'soft') card.classList.add('shadow-[0_4px_20px_rgb(0,0,0,0.04)]');
                if (shadow === 'strong') card.classList.add('shadow-lg', 'hover:-translate-y-1.5');
            } else {
                if (shadow === 'soft') card.classList.add('shadow-sm');
                if (shadow === 'strong') card.classList.add('shadow-md');
            }

            // Buttons Logic
            let btnL = inputs.btnLayout.value;
            if (btnL === 'text_only') {
                btnIcon.classList.add('hidden');
                btnText.classList.remove('hidden');
            } else if (btnL === 'icon_only') {
                btnIcon.classList.remove('hidden');
                btnText.classList.add('hidden');
                btnIcon.classList.replace('w-4', 'w-5'); // make icon slightly bigger if alone
                btnIcon.classList.replace('h-4', 'h-5');
            } else {
                btnIcon.classList.remove('hidden');
                btnText.classList.remove('hidden');
                btnIcon.classList.replace('w-5', 'w-4');
                btnIcon.classList.replace('h-5', 'h-4');
            }

            // Wishlist logic
            if (inputs.wishlist.value === 'true') {
                wishlistBtn.classList.remove('hidden');
            } else {
                wishlistBtn.classList.add('hidden');
            }
        }

        // Attach listeners
        Object.values(inputs).forEach(el => {
            if (el && el.tagName) { // exclude bgLabel
                el.addEventListener('input', updatePreview);
                el.addEventListener('change', updatePreview);
            }
        });

        // Initialize
        updatePreview();
    });
</script>
@endsection
