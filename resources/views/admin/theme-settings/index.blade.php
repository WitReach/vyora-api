@extends('layouts.admin')

@section('header', 'Theme Customization')

@section('content')
    <div class="w-full">
        <form action="{{ route('admin.online-store.theme-settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-8">
                {{-- Colors Section --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-indigo-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                            Brand Colors
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Define the core color palette that represents your brand identity.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Primary Color</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white flex items-center p-1.5 overflow-hidden">
                                <div class="h-9 w-10 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 ring-1 ring-black/5 shadow-inner">
                                    <input type="color" name="primary_color"
                                        value="{{ $settings->get('colors', collect())->where('key', 'primary_color')->first()->value ?? '#000000' }}"
                                        class="h-16 w-16 -m-3 cursor-pointer border-0 p-0">
                                </div>
                                <input type="text"
                                    value="{{ $settings->get('colors', collect())->where('key', 'primary_color')->first()->value ?? '#000000' }}"
                                    class="block w-full border-0 py-1.5 pl-3 text-gray-900 focus:ring-0 sm:text-sm uppercase font-mono bg-transparent"
                                    onchange="this.previousElementSibling.querySelector('input[type=color]').value = this.value">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 transition-opacity">Main buttons, links, and highlights.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Secondary Color</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white flex items-center p-1.5 overflow-hidden">
                                <div class="h-9 w-10 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 ring-1 ring-black/5 shadow-inner">
                                    <input type="color" name="secondary_color"
                                        value="{{ $settings->get('colors', collect())->where('key', 'secondary_color')->first()->value ?? '#ffffff' }}"
                                        class="h-16 w-16 -m-3 cursor-pointer border-0 p-0">
                                </div>
                                <input type="text"
                                    value="{{ $settings->get('colors', collect())->where('key', 'secondary_color')->first()->value ?? '#ffffff' }}"
                                    class="block w-full border-0 py-1.5 pl-3 text-gray-900 focus:ring-0 sm:text-sm uppercase font-mono bg-transparent"
                                    onchange="this.previousElementSibling.querySelector('input[type=color]').value = this.value">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 transition-opacity">Backgrounds and secondary elements.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Accent Color</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white flex items-center p-1.5 overflow-hidden">
                                <div class="h-9 w-10 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 ring-1 ring-black/5 shadow-inner">
                                    <input type="color" name="accent_color"
                                        value="{{ $settings->get('colors', collect())->where('key', 'accent_color')->first()->value ?? '#3b82f6' }}"
                                        class="h-16 w-16 -m-3 cursor-pointer border-0 p-0">
                                </div>
                                <input type="text"
                                    value="{{ $settings->get('colors', collect())->where('key', 'accent_color')->first()->value ?? '#3b82f6' }}"
                                    class="block w-full border-0 py-1.5 pl-3 text-gray-900 focus:ring-0 sm:text-sm uppercase font-mono bg-transparent"
                                    onchange="this.previousElementSibling.querySelector('input[type=color]').value = this.value">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 transition-opacity">Sale badges, alerts, and notifications.</p>
                        </div>
                    </div>
                </div>

                {{-- Typography Section --}}
                <div class="relative z-50 bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-emerald-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </div>
                            Typography
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Choose beautifully tailored Google Fonts for your store.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Heading Font Family</label>
                            <div class="relative">
                                <select name="heading_font" class="font-select block w-full text-gray-900" placeholder="Select a heading font...">
                                    <option value="">Select a font...</option>
                                    @foreach($googleFonts as $font)
                                        <option value="{{ $font }}" {{ ($settings->get('typography', collect())->where('key', 'heading_font')->first()->value ?? 'Inter') == $font ? 'selected' : '' }}>{{ $font }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Body Font Family</label>
                            <div class="relative">
                                <select name="body_font" class="font-select block w-full text-gray-900" placeholder="Select a body font...">
                                    <option value="">Select a font...</option>
                                    @foreach($googleFonts as $font)
                                        <option value="{{ $font }}" {{ ($settings->get('typography', collect())->where('key', 'body_font')->first()->value ?? 'Open Sans') == $font ? 'selected' : '' }}>{{ $font }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Layout Section --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-slate-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M10 4v16"></path>
                                </svg>
                            </div>
                            Layout & Structure
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Define the structural wrapper for your storefront pages.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Default Page Layout</label>
                            <div class="relative">
                                <select name="default_page_layout" class="block w-full text-gray-900 rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 bg-white/50 hover:bg-white transition-colors cursor-pointer border ring-1 ring-inset ring-gray-200">
                                    @php $layoutVal = $settings->get('layout', collect())->where('key', 'default_page_layout')->first()->value ?? 'contained'; @endphp
                                    <option value="contained" {{ $layoutVal === 'contained' ? 'selected' : '' }}>Contained Wrapper (Default Max-Width)</option>
                                    <option value="fluid" {{ $layoutVal === 'fluid' ? 'selected' : '' }}>Fluid Full-Width (Edge-to-Edge)</option>
                                </select>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 transition-opacity">Serves as default. Can be overridden per page.</p>
                        </div>
                    </div>
                </div>

                {{-- Store Information Section --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-blue-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            Store Information
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Configure the main details of your online store.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Store Name</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="text" name="store_name"
                                    value="{{ $settings->get('store_info', collect())->where('key', 'store_name')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="e.g. Dope Style Store">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tagline</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="text" name="store_tagline"
                                    value="{{ $settings->get('store_info', collect())->where('key', 'store_tagline')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="e.g. Your premium destination for style">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Information Section --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-orange-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            Contact Information
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">How customers can reach out to you.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="email" name="contact_email"
                                    value="{{ $settings->get('contact', collect())->where('key', 'contact_email')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="e.g. support@dopestyle.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="text" name="contact_phone"
                                    value="{{ $settings->get('contact', collect())->where('key', 'contact_phone')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="e.g. +1 234 567 8900">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Social Media Links Section --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-purple-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            Social Media Links
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Connect your community across different platforms.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Facebook</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="url" name="social_facebook"
                                    value="{{ $settings->get('social', collect())->where('key', 'social_facebook')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="https://facebook.com/yourpage">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Twitter / X</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="url" name="social_twitter"
                                    value="{{ $settings->get('social', collect())->where('key', 'social_twitter')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="https://twitter.com/yourhandle">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Instagram</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="url" name="social_instagram"
                                    value="{{ $settings->get('social', collect())->where('key', 'social_instagram')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="https://instagram.com/yourhandle">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">LinkedIn</label>
                            <div class="group relative rounded-xl shadow-sm ring-1 ring-inset ring-gray-200 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 transition-all duration-200 bg-white overflow-hidden">
                                <input type="url" name="social_linkedin"
                                    value="{{ $settings->get('social', collect())->where('key', 'social_linkedin')->first()->value ?? '' }}"
                                    class="block w-full border-0 py-2.5 px-4 text-gray-900 focus:ring-0 sm:text-sm bg-transparent"
                                    placeholder="https://linkedin.com/company/yourcompany">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Logistics / Logos --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl border border-gray-100 p-8 transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="mb-8 border-b border-gray-100 pb-5">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <div class="bg-rose-50 p-2 rounded-lg mr-3 shadow-sm">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            Store Identity
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 ml-11">Upload your brand's core visual assets like logos and favicons.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Main Logo</label>
                            <div class="flex items-start space-x-6">
                                @if($logo = ($settings->get('logos', collect())->where('key', 'main_logo')->first() ?? null))
                                    <div class="flex-shrink-0 border border-gray-200 bg-white p-3 rounded-2xl shadow-sm">
                                        <img src="{{ Storage::url($logo->value) }}" alt="Main Logo" class="h-16 w-auto object-contain drop-shadow-sm">
                                    </div>
                                @endif
                                <label class="relative flex-1 block w-full rounded-2xl border-2 border-dashed border-gray-300 p-6 text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition duration-200 ease-in-out cursor-pointer group bg-gray-50/30">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-semibold text-gray-900 group-hover:text-indigo-600">Upload New Main Logo</span>
                                    <span class="mt-1 block text-xs text-gray-500">Recommended height: 40-60px (PNG or SVG)</span>
                                    <input type="file" name="logos[main_logo]" class="sr-only">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Favicon</label>
                            <div class="flex items-start space-x-6">
                                @if($favicon = ($settings->get('logos', collect())->where('key', 'favicon')->first() ?? null))
                                    <div class="flex-shrink-0 border border-gray-200 bg-white p-4 rounded-2xl shadow-sm">
                                        <img src="{{ Storage::url($favicon->value) }}" alt="Favicon" class="h-10 w-10 object-contain drop-shadow-sm">
                                    </div>
                                @endif
                                <label class="relative flex-1 block w-full rounded-2xl border-2 border-dashed border-gray-300 p-6 text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition duration-200 ease-in-out cursor-pointer group bg-gray-50/30">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-semibold text-gray-900 group-hover:text-indigo-600">Upload New Favicon</span>
                                    <span class="mt-1 block text-xs text-gray-500">32x32px or 16x16px (PNG/ICO)</span>
                                    <input type="file" name="logos[favicon]" class="sr-only">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Social Preview Image</label>
                            <div class="flex items-start space-x-6">
                                @if($social = ($settings->get('logos', collect())->where('key', 'social_preview_image')->first() ?? null))
                                    <div class="flex-shrink-0 border border-gray-200 bg-white p-4 rounded-2xl shadow-sm">
                                        <img src="{{ Storage::url($social->value) }}" alt="Social Preview Image" class="h-10 w-10 object-contain drop-shadow-sm">
                                    </div>
                                @endif
                                <label class="relative flex-1 block w-full rounded-2xl border-2 border-dashed border-gray-300 p-6 text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition duration-200 ease-in-out cursor-pointer group bg-gray-50/30">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 group-hover:text-indigo-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="mt-3 block text-sm font-semibold text-gray-900 group-hover:text-indigo-600">Upload New Social Preview Image</span>
                                    <span class="mt-1 block text-xs text-gray-500">1200x630px ideally (JPG/PNG)</span>
                                    <input type="file" name="logos[social_preview_image]" class="sr-only">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection