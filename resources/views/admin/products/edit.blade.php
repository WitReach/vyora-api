@extends('layouts.admin')

@section('header', 'Edit Product')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-container.ql-snow { border: none !important; }
        .ql-toolbar.ql-snow { border: none !important; border-bottom: 1px solid #f3f4f6 !important; background: #f9fafb; border-radius: 12px 12px 0 0; }
        .ql-editor { min-height: 200px; font-size: 14px; line-height: 1.6; color: #111827; }
        .tab-active { background: black; color: white !important; shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e5e7eb; transition: .4s; border-radius: 24px; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input:checked + .slider { background-color: #10b981; }
        input:checked + .slider:before { transform: translateX(20px); }
    </style>
@endpush

@section('content')
<div class="w-full pb-32">
    {{-- Breadcrumbs & Header --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl overflow-hidden bg-white border border-gray-100 shadow-sm">
                    @if($product->preview_image)
                        <img src="/{{ $product->preview_image }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                             <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Edit Product</h1>
                    <div class="flex items-center gap-3 mt-1.5 font-bold text-[10px] uppercase tracking-wider">
                        <span class="text-gray-400">ID: {{ $product->id }}</span>
                        <span class="text-gray-300">|</span>
                        <span class="{{ $product->is_active ? 'text-green-600' : 'text-amber-500' }}">
                            {{ $product->is_active ? '● Live' : '○ Draft' }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <a href="#" class="text-violet-600 hover:underline">View on Store</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white/50 backdrop-blur-sm p-1 rounded-xl shadow-sm border border-gray-200/50 flex">
                    <button type="button" data-tab="info" class="tab-button px-5 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition-all duration-200 tab-active">Product Info</button>
                    <button type="button" data-tab="skus" class="tab-button px-5 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition-all duration-200 text-gray-500 hover:text-gray-900">SKUs & Variants</button>
                    <button type="button" data-tab="media" class="tab-button px-5 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition-all duration-200 text-gray-500 hover:text-gray-900">Media Gallery</button>
                </div>
            </div>
        </div>
    </div>

    <form id="update-product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="redirect_tab" id="redirect-tab" value="info">

        {{-- Tab content shared wrapper --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Main Content Area --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- TAB: INFO --}}
                <div id="tab-info" class="tab-content space-y-6">
                    <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 p-8">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                             <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                             Basic Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Product Name</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-violet-500 transition-all text-lg tracking-tight">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Slug</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-xs font-bold text-gray-400">/product/</span>
                                    </div>
                                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" 
                                        class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 pl-20 pr-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all tracking-tight">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Brand Name</label>
                                <input type="text" name="brand_name" value="{{ old('brand_name', $product->brand_name) }}" 
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 px-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                        </div>

                        <div class="mt-8 space-y-6">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Short Description</label>
                                <div class="ring-1 ring-gray-100 rounded-3xl overflow-hidden shadow-inner bg-white border border-gray-100">
                                    <div id="short-description-editor" class="min-h-[120px]">{!! old('short_description', $product->short_description) !!}</div>
                                    <textarea name="short_description" class="hidden">{!! old('short_description', $product->short_description) !!}</textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Long Description</label>
                                <div class="ring-1 ring-gray-100 rounded-3xl overflow-hidden shadow-inner bg-white border border-gray-100">
                                    <div id="long-description-editor" class="min-h-[300px]">{!! old('long_description', $product->long_description) !!}</div>
                                    <textarea name="long_description" class="hidden">{!! old('long_description', $product->long_description) !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Search Engine Optimization Card --}}
                    <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-pink-500 rounded-full"></div>
                                SEO
                            </h3>
                            <div class="flex items-center gap-2 px-3 py-1 bg-violet-50 text-violet-700 text-[10px] font-black uppercase tracking-wider rounded-lg border border-violet-100">
                                Google Preview Enabled
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400">SEO Title Tag</label>
                                    <span id="seo-title-count" class="text-[10px] font-black text-gray-400 tracking-wider">0 / 60</span>
                                </div>
                                <input type="text" name="seo_title" id="seo-title-input" value="{{ old('seo_title', $product->seo_title) }}" maxlength="60"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 px-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                                <p class="text-[10px] text-gray-400 mt-2 font-medium italic">Appears in search engine results and browser tabs.</p>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400">Meta Description</label>
                                    <span id="seo-description-count" class="text-[10px] font-black text-gray-400 tracking-wider">0 / 160</span>
                                </div>
                                <textarea name="seo_description" id="seo-description-input" rows="3" maxlength="160"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 px-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all resize-none">{{ old('seo_description', $product->seo_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: SKUs --}}
                <div id="tab-skus" class="tab-content hidden space-y-6">
                    <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 overflow-hidden">
                        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                                SKUs & Variants
                            </h3>
                            <div class="flex gap-2">
                                <button type="button" onclick="copyToAll('sku-price')" class="text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition-colors">Sync Prices</button>
                                <button type="button" onclick="copyToAll('sku-stock')" class="text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg hover:bg-gray-200 transition-colors">Sync Stock</button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="pl-8 pr-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">SKU</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Attributes</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Price</th>
                                        <th class="px-4 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Stock</th>
                                        <th class="pr-8 pl-4 py-4 text-right text-[10px] font-black uppercase tracking-widest text-gray-400">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($product->skus as $sku)
                                        <tr class="group hover:bg-gray-50/30 transition-colors">
                                            <td class="pl-8 pr-4 py-4">
                                                <input type="hidden" name="skus[{{ $sku->id }}][id]" value="{{ $sku->id }}">
                                                <input type="text" name="skus[{{ $sku->id }}][code]" value="{{ $sku->code }}"
                                                    class="bg-white border-0 ring-1 ring-gray-100 rounded-xl px-3 py-1.5 text-xs font-bold text-gray-900 focus:ring-violet-500 w-full max-w-[140px] uppercase shadow-sm">
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex items-center justify-center gap-3">
                                                    @if($sku->color)
                                                        <div class="flex items-center gap-1.5 bg-white border border-gray-100 px-2.5 py-1 rounded-full shadow-sm ring-1 ring-black/5" title="{{ $sku->color->name }}">
                                                            <div class="w-3 h-3 rounded-full border border-black/10 group-hover:scale-125 transition-transform" style="background-color: {{ $sku->color->hex_code ?? '#ccc' }}"></div>
                                                            <span class="text-[9px] font-black uppercase tracking-tighter text-gray-500">{{ $sku->color->name }}</span>
                                                        </div>
                                                    @endif
                                                    @if($sku->size)
                                                        <div class="bg-gray-50 text-gray-700 px-2 py-1 rounded-md text-[10px] font-black border border-gray-100 uppercase">{{ $sku->size->name }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="relative max-w-[120px]">
                                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] font-black">₹</span>
                                                    <input type="number" step="0.01" name="skus[{{ $sku->id }}][price]" value="{{ $sku->price }}"
                                                        class="sku-price block w-full bg-white border-0 ring-1 ring-gray-100 rounded-xl pl-6 pr-3 py-2 text-xs font-black text-gray-900 focus:ring-violet-500 shadow-sm">
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <input type="number" name="skus[{{ $sku->id }}][stock]" value="{{ $sku->stock }}"
                                                    class="sku-stock block w-20 bg-white border-0 ring-1 ring-gray-100 rounded-xl px-3 py-2 text-xs font-black text-gray-900 focus:ring-violet-500 shadow-sm {{ $sku->stock <= 5 ? 'text-amber-600 ring-amber-100' : '' }}">
                                            </td>
                                            <td class="pr-8 pl-4 py-4 text-right">
                                                <button type="button" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Add New Variant Section --}}
                        <div class="p-8 bg-gray-50/50 border-t border-gray-50">
                            <h4 class="text-xs font-black uppercase tracking-[0.2em] text-gray-400 mb-6 italic">Add New SKUs</h4>
                            <div id="new-variants-container" class="space-y-4"></div>
                            
                            <button type="button" onclick="addNewVariantRow()" class="mt-4 inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-900 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:border-violet-300 hover:shadow-md transition-all group">
                                <span class="w-5 h-5 flex items-center justify-center bg-violet-600 text-white rounded-lg group-hover:scale-110 transition-transform font-normal text-lg">+</span>
                                Add SKU
                            </button>
                        </div>
                    </div>
                </div>

                {{-- TAB: MEDIA --}}
                <div id="tab-media" class="tab-content hidden space-y-8">
                     {{-- Master Product Preview --}}
                    <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 p-8">
                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest flex items-center gap-2 mb-8">
                             <div class="w-1.5 h-6 bg-black rounded-full"></div>
                             Master Image
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
                            <div class="relative group aspect-[3/4] bg-gray-50 rounded-3xl overflow-hidden border-2 border-dashed border-gray-200 hover:border-black transition-all cursor-pointer shadow-inner" onclick="document.getElementById('master-image-input').click()">
                                <div id="master-image-preview-container" class="w-full h-full flex items-center justify-center {{ $product->preview_image ? '' : 'hidden' }}">
                                    <img src="{{ $product->preview_image ? asset($product->preview_image) : '' }}" id="master-image-preview" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                         <span class="bg-white text-black px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl">Change Master</span>
                                    </div>
                                </div>
                                <div id="master-image-no-preview" class="w-full h-full flex flex-col items-center justify-center text-gray-400 gap-2 {{ $product->preview_image ? 'hidden' : '' }}">
                                     <svg class="w-10 h-10 opaicty-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                     <span class="text-[10px] font-black uppercase tracking-widest">Select Image</span>
                                </div>
                                <input type="file" name="preview_image" accept="image/*" class="hidden" id="master-image-input">
                            </div>

                            <div class="md:col-span-2 space-y-6">
                                <div class="bg-black rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/5 blur-3xl rounded-full"></div>
                                    <p class="text-sm font-medium leading-relaxed italic text-gray-300 pr-10">This image acts as the primary visual for catalog listings. High contrast on neutral backgrounds works best.</p>
                                </div>
                                <div class="flex items-center gap-4">
                                     <div class="flex-1 border border-gray-100 bg-gray-50 rounded-xl p-4">
                                          <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">Recommended</div>
                                          <div class="text-xs font-black text-gray-700">800 &times; 900px or Square</div>
                                     </div>
                                     <div class="flex-1 border border-gray-100 bg-gray-50 rounded-xl p-4">
                                          <div class="text-[10px] font-bold text-gray-400 uppercase mb-1">Format</div>
                                          <div class="text-xs font-black text-gray-700">WebP, PNG, JPG</div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Color-Specific Galleries --}}
                    <div class="space-y-6">
                        @foreach($productColors as $color)
                            <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 overflow-hidden" data-color-id="{{ $color->id }}">
                                <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full border-2 border-white shadow-md ring-1 ring-black/5" style="background-color: {{ $color->hex_code ?? '#ccc' }}"></div>
                                        <div>
                                            <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">{{ $color->name }} Gallery</h4>
                                            <p class="text-[10px] font-bold text-gray-400 mt-0.5">Automated sorting enabled</p>
                                        </div>
                                    </div>
                                    <label class="cursor-pointer bg-black text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:shadow-lg transition-all active:scale-95">
                                        <input type="file" multiple accept="image/*,video/*" class="hidden media-upload-input" data-color-id="{{ $color->id }}">
                                        + Batch Sync Media
                                    </label>
                                </div>

                                <div class="p-6">
                                     <!-- Drag-Drop Upload Zone -->
                                    <div class="drag-drop-zone group border-2 border-dashed border-gray-200 rounded-2xl p-8 mb-6 text-center transition-all hover:border-violet-400 hover:bg-violet-50/30 cursor-pointer" data-color-id="{{ $color->id }}">
                                        <div class="mx-auto w-10 h-10 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 group-hover:text-violet-500 group-hover:scale-110 transition-all mb-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <p class="text-xs font-black text-gray-900 uppercase tracking-widest">Drop assets here</p>
                                        <p class="text-[10px] text-gray-400 mt-1 font-medium font-mono">JPG, WebP, MP4</p>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 media-gallery" id="media-gallery-{{ $color->id }}">
                                        @if(isset($mediaByColor[$color->id]))
                                            @foreach($mediaByColor[$color->id] as $media)
                                                <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm media-item" data-media-id="{{ $media->id }}">
                                                    <!-- Drag Handle -->
                                                    <div class="absolute top-2 left-2 z-10 w-6 h-6 bg-white/80 backdrop-blur-md rounded-lg flex items-center justify-center text-gray-400 shadow-sm drag-handle opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                                                    </div>

                                                    @if($media->media_type === 'video')
                                                        <video src="{{ $media->url }}" class="w-full h-full object-cover"></video>
                                                    @else
                                                        <img src="{{ $media->url }}" class="w-full h-full object-cover">
                                                    @endif

                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                                        <button type="button" class="p-2 bg-white text-gray-900 rounded-xl hover:bg-violet-600 hover:text-white transition-all shadow-xl">
                                                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        </button>
                                                        <button type="button" class="p-2 bg-white text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-xl delete-media-btn" data-media-id="{{ $media->id }}" data-product-id="{{ $product->id }}">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Status & Config --}}
            <div class="lg:col-span-4 space-y-6">
                 {{-- Publishing Controls --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 p-8">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 italic">Publishing</h3>
                    
                    <div class="space-y-5">
                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition-all hover:bg-white hover:shadow-sm">
                            <div>
                                <h5 class="text-sm font-black text-gray-900">Active Status</h5>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">Visible to customers</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition-all hover:bg-white hover:shadow-sm">
                            <div>
                                <h5 class="text-sm font-black text-gray-900">On Sale</h5>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">Highlight discounts</p>
                            </div>
                            <input type="checkbox" name="on_sale" value="1" {{ $product->on_sale ? 'checked' : '' }} class="w-5 h-5 rounded-md border-gray-200 text-violet-600 focus:ring-violet-500">
                        </div>

                         <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition-all hover:bg-white hover:shadow-sm">
                            <div>
                                <h5 class="text-sm font-black text-gray-900">Returnable</h5>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">Standard policy sync</p>
                            </div>
                            <input type="checkbox" name="is_returnable" value="1" {{ $product->is_returnable ? 'checked' : '' }} class="w-5 h-5 rounded-md border-gray-200 text-violet-600 focus:ring-violet-500">
                        </div>
                    </div>
                </div>

                {{-- Classification Card --}}
                <div class="bg-white/80 backdrop-blur-lg shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-3xl border border-gray-100 p-8 overflow-hidden relative">
                     <div class="absolute -right-4 -top-4 w-24 h-24 bg-violet-50 rounded-full blur-2xl opacity-50"></div>
                      <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                          Organization
                      </h3>

                     <div class="space-y-6">
                        <div>
                             <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Product Type</label>
                             <select name="product_type_id" class="w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 px-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                                <option value="">None Specified</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->id }}" {{ $product->product_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }} (HSN: {{ $type->hsn_code }})</option>
                                @endforeach
                             </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Categories</label>
                            <div class="max-h-60 overflow-y-auto space-y-3 pr-2 scrollbar-thin">
                                @foreach($categories as $category)
                                    <label class="flex items-center gap-3 group cursor-pointer">
                                        <div class="relative flex items-center justify-center w-5 h-5 bg-white border border-gray-200 rounded-lg group-hover:border-violet-400 transition-all">
                                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'checked' : '' }} class="peer opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                                            <div class="w-2 h-2 bg-violet-600 rounded-sm opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-600 group-hover:text-gray-900 transition-colors">{{ $category->name }}</span>
                                    </label>
                                    @foreach($category->children as $child)
                                        <label class="flex items-center gap-3 group pl-8 cursor-pointer">
                                            <div class="relative flex items-center justify-center w-4 h-4 bg-white border border-gray-200 rounded-lg group-hover:border-violet-400 transition-all">
                                                <input type="checkbox" name="categories[]" value="{{ $child->id }}" {{ $product->categories->contains($child->id) ? 'checked' : '' }} class="peer opacity-0 absolute inset-0 w-full h-full cursor-pointer">
                                                <div class="w-1.5 h-1.5 bg-violet-400 rounded-sm opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-400 group-hover:text-gray-900 transition-colors">{{ $child->name }}</span>
                                        </label>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <div>
                             <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2">Size Chart</label>
                             <select name="size_chart_id" class="w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-3 px-4 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all font-mono tracking-tighter">
                                <option value="">No Global Mapping</option>
                                @foreach($sizeCharts as $chart)
                                    <option value="{{ $chart->id }}" {{ old('size_chart_id', $product->sizeChart->first()->id ?? '') == $chart->id ? 'selected' : '' }}>{{ $chart->name }}</option>
                                @endforeach
                             </select>
                        </div>
                     </div>
                </div>
            </div>
        </div>

        {{-- Fixed Bottom Global Actions --}}
        <div class="fixed bottom-0 left-0 right-0 h-20 bg-white/70 backdrop-blur-2xl border-t border-gray-100 z-50 md:pl-64 transition-all duration-300">
            <div class="max-w-7xl mx-auto h-full px-8 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <button type="button" onclick="document.getElementById('delete-product-form').submit()" class="group flex items-center gap-2 text-gray-300 hover:text-red-500 transition-colors font-black uppercase tracking-widest text-xs">
                        <div class="p-2.5 rounded-xl border border-transparent group-hover:border-red-100 group-hover:bg-red-50 transition-all">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                        Archive Product
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">Discard</a>
                    <button type="submit" class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Hidden Delete Form --}}
    <form id="delete-product-form" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

{{-- Templates --}}
<template id="new-variant-template">
    <div class="grid grid-cols-12 gap-3 mb-3 p-4 bg-white ring-1 ring-gray-100 rounded-2xl shadow-sm new-variant-row items-center border border-transparent hover:border-violet-100 hover:shadow-md transition-all">
        <div class="col-span-2">
            <input type="text" name="new_skus[INDEX][code]" placeholder="CODE-123" class="w-full bg-gray-50 border-0 ring-1 ring-gray-100 rounded-xl px-3 py-2 text-[10px] font-black uppercase focus:ring-violet-500">
        </div>
        <div class="col-span-2">
            <select name="new_skus[INDEX][color_id]" class="w-full bg-gray-50 border-0 ring-1 ring-gray-100 rounded-xl px-2 py-2 text-[10px] font-black focus:ring-violet-500">
                <option value="">COLOR</option>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2">
            <select name="new_skus[INDEX][size_id]" class="w-full bg-gray-50 border-0 ring-1 ring-gray-100 rounded-xl px-2 py-2 text-[10px] font-black focus:ring-violet-500">
                <option value="">SIZE</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-span-2">
            <div class="relative">
                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-[10px] text-gray-400">₹</span>
                <input type="number" step="0.01" name="new_skus[INDEX][price]" placeholder="99.00" class="w-full bg-gray-50 border-0 ring-1 ring-gray-100 rounded-xl pl-5 pr-2 py-2 text-[10px] font-black focus:ring-violet-500">
            </div>
        </div>
        <div class="col-span-2">
            <input type="number" name="new_skus[INDEX][stock]" placeholder="STOCK" class="w-full bg-gray-50 border-0 ring-1 ring-gray-100 rounded-xl px-3 py-2 text-[10px] font-black focus:ring-violet-500">
        </div>
        <div class="col-span-2 text-right">
            <button type="button" onclick="this.closest('.new-variant-row').remove()" class="p-2 text-red-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // High Reliability Tab System
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const redirectInput = document.getElementById('redirect-tab');

            function activateTab(tabName) {
                if (redirectInput) redirectInput.value = tabName;
                tabButtons.forEach(btn => {
                    const isActive = btn.dataset.tab === tabName;
                    btn.className = `tab-button px-5 py-2 text-xs font-black uppercase tracking-widest rounded-lg transition-all duration-200 ${isActive ? 'tab-active' : 'text-gray-500 hover:text-gray-900'}`;
                });
                tabContents.forEach(content => content.classList.toggle('hidden', content.id !== `tab-${tabName}`));
            }

            tabButtons.forEach(button => button.addEventListener('click', () => {
                activateTab(button.dataset.tab);
                history.pushState(null, null, `#${button.dataset.tab}`);
            }));

            const hash = window.location.hash.substring(1);
            activateTab(hash && document.getElementById(`tab-${hash}`) ? hash : 'info');

            // Quill Configuration
            const toolbarOptions = [['bold', 'italic', 'underline'], [{ 'list': 'ordered' }, { 'list': 'bullet' }], ['link', 'clean']];
            const qShort = new Quill('#short-description-editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });
            const qLong = new Quill('#long-description-editor', { theme: 'snow', modules: { toolbar: toolbarOptions } });
            
            const shortText = document.querySelector('textarea[name="short_description"]');
            const longText = document.querySelector('textarea[name="long_description"]');

            qShort.on('text-change', () => shortText.value = qShort.root.innerHTML);
            qLong.on('text-change', () => longText.value = qLong.root.innerHTML);

            // Form Submit Sync
            document.getElementById('update-product-form').addEventListener('submit', () => {
                shortText.value = qShort.root.innerHTML;
                longText.value = qLong.root.innerHTML;
            });

            // Master Image Preview
            const masterInput = document.getElementById('master-image-input');
            const masterPreview = document.getElementById('master-image-preview');
            const masterPrevCont = document.getElementById('master-image-preview-container');
            const masterEmpty = document.getElementById('master-image-no-preview');

            masterInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        masterPreview.src = e.target.result;
                        masterPrevCont.classList.remove('hidden');
                        masterEmpty.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Media Upload Handler (Browse button)
            document.querySelectorAll('.media-upload-input').forEach(input => {
                input.addEventListener('change', function (e) {
                    const colorId = this.dataset.colorId;
                    const files = e.target.files;
                    if (files.length > 0) uploadFiles(files, colorId);
                    e.target.value = '';
                });
            });

            // Common upload function
            function uploadFiles(files, colorId) {
                const formData = new FormData();
                formData.append('color_id', colorId);
                for (let i = 0; i < files.length; i++) formData.append('files[]', files[i]);

                const gallery = document.querySelector(`#media-gallery-${colorId}`);
                const emptyState = gallery.querySelector('.empty-state');
                if (emptyState) emptyState.remove();

                fetch(`/admin/products/{{ $product->id }}/media/upload`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.media.forEach(media => {
                            const mediaHtml = createMediaItemHtml(media, {{ $product->id }});
                            gallery.insertAdjacentHTML('beforeend', mediaHtml);
                        });
                        initializeSortable(gallery);
                    }
                })
                .catch(error => alert('Upload failed.'));
            }

            function createMediaItemHtml(media, productId) {
                const isVideo = media.media_type === 'video';
                return `
                    <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 shadow-sm media-item" data-media-id="${media.id}">
                        <div class="absolute top-2 left-2 z-10 w-6 h-6 bg-white/80 backdrop-blur-md rounded-lg flex items-center justify-center text-gray-400 shadow-sm drag-handle opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path></svg>
                        </div>
                        ${isVideo ? `<video src="${media.url}" class="w-full h-full object-cover"></video>` : `<img src="${media.url}" class="w-full h-full object-cover">`}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                             <button type="button" class="p-2 bg-white text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-xl delete-media-btn" data-media-id="${media.id}" data-product-id="${productId}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                `;
            }

            // Global Delete Handler
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-media-btn')) {
                    const btn = e.target.closest('.delete-media-btn');
                    const mediaId = btn.dataset.mediaId;
                    const productId = btn.dataset.productId;
                    if (confirm('Permanently delete this asset?')) {
                        fetch(`/admin/products/${productId}/media/${mediaId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) btn.closest('.media-item').remove();
                        });
                    }
                }
            });

            // Drag and Drop Zone logic
            document.querySelectorAll('.drag-drop-zone').forEach(zone => {
                const colorId = zone.dataset.colorId;
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => zone.addEventListener(ev, (e) => { e.preventDefault(); e.stopPropagation(); }));
                zone.addEventListener('dragenter', () => zone.classList.add('bg-violet-50/50', 'border-violet-300'));
                zone.addEventListener('dragleave', () => zone.classList.remove('bg-violet-50/50', 'border-violet-300'));
                zone.addEventListener('drop', (e) => {
                    zone.classList.remove('bg-violet-50/50', 'border-violet-300');
                    if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files, colorId);
                });
                zone.addEventListener('click', () => {
                     const input = zone.closest('[data-color-id]').querySelector('.media-upload-input');
                     if (input) input.click();
                });
            });

            function initializeSortable(el) {
                new Sortable(el, {
                    animation: 150,
                    handle: '.drag-handle',
                    ghostClass: 'opacity-20',
                    onEnd: function() {
                        const mediaIds = Array.from(el.querySelectorAll('.media-item')).map(item => item.dataset.mediaId);
                        fetch(`/admin/products/{{ $product->id }}/media/sort`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ media_ids: mediaIds })
                        });
                    }
                });
            }

            // Reorder / Sortable Logic
            document.querySelectorAll('.media-gallery').forEach(gallery => initializeSortable(gallery));

            // Global SEO Counter
            const setupCounter = (inputId, countId, max) => {
                const input = document.getElementById(inputId);
                const count = document.getElementById(countId);
                if (input && count) {
                    const update = () => count.innerText = `${input.value.length} / ${max}`;
                    input.addEventListener('input', update);
                    update();
                }
            };
            setupCounter('seo-title-input', 'seo-title-count', 60);
            setupCounter('seo-description-input', 'seo-description-count', 160);
        });

        let newVariantIndex = 0;
        function addNewVariantRow() {
            const container = document.getElementById('new-variants-container');
            const template = document.getElementById('new-variant-template');
            const div = document.createElement('div');
            div.innerHTML = template.innerHTML.replace(/INDEX/g, newVariantIndex++);
            container.appendChild(div.firstElementChild);
        }

        function copyToAll(className) {
            const first = document.querySelector(`.${className}`);
            if (first) {
                document.querySelectorAll(`.${className}`).forEach(input => input.value = first.value);
            }
        }
    </script>
@endpush