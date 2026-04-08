@extends('layouts.admin')

@section('header', 'Edit Collection')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Edit Collection</h1>
        </div>
        
        <div class="flex items-center gap-4">
             <a href="{{ route('admin.collections.index') }}" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 hover:bg-white transition-all">Cancel</a>
             <button type="submit" form="edit-collection-form" class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                Update Collection
            </button>
        </div>
    </div>

    <form id="edit-collection-form" action="{{ route('admin.collections.update', $collection) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            {{-- Main Column --}}
            <div class="md:col-span-2 space-y-8">
                {{-- Basic Settings --}}
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-10 flex items-center gap-3">
                         <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                         General Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Collection Name</label>
                            <input type="text" name="name" value="{{ $collection->name }}" required placeholder="e.g. Summer Essentials"
                                class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-violet-500 transition-all text-lg tracking-tight">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Slug</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">/</span>
                                </div>
                                <input type="text" name="slug" value="{{ $collection->slug }}" required placeholder="summer-essentials"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 pl-8 pr-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all font-mono italic">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Brief Description</label>
                             <textarea name="description" rows="4" placeholder="Describe the theme and purpose of this collection..."
                                 class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl p-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all resize-none leading-relaxed">{{ $collection->description }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Product Registry (Selection) --}}
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-2 flex items-center gap-3">
                         <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                         Product Selection
                    </h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-10 ml-4 italic">Curation & Registry Management</p>

                    <div class="space-y-6">
                        {{-- Search Input --}}
                        <div class="relative">
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1 text-right">Add Products</label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400 group-focus-within:text-violet-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" id="product-search" placeholder="Search products by name..."
                                    class="block w-full bg-gray-100/50 border-0 ring-1 ring-inset ring-gray-200 rounded-2xl py-4 h-16 pl-12 pr-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all shadow-sm">
                            </div>
                            <div id="search-results" class="absolute z-50 w-full bg-white shadow-2xl rounded-2xl mt-2 max-h-80 overflow-y-auto hidden border border-gray-100/50 backdrop-blur-xl divide-y divide-gray-50">
                                <!-- Results populated by JS -->
                            </div>
                        </div>

                        {{-- Selected List --}}
                        <div class="pt-6 border-t border-gray-50">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400">Current Assignments</h4>
                                <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest" id="item-count">{{ $collection->products->count() }} Items</span>
                            </div>

                            <div id="selected-products" class="grid grid-cols-1 gap-4 min-h-[120px] max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($collection->products as $product)
                                    <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 group/product hover:bg-white hover:shadow-md transition-all" data-id="{{ $product->id }}">
                                        <div class="flex items-center gap-4">
                                            <input type="hidden" name="products[]" value="{{ $product->id }}">
                                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-white border border-gray-100 flex-shrink-0">
                                                @if($product->preview_image)
                                                    <img src="{{ Storage::url($product->preview_image) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-[10px] font-black text-gray-300 uppercase">NO IMG</div>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-sm font-black text-gray-900 line-clamp-1 tracking-tight">{{ $product->name }}</span>
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">SKU: {{ $product->sku ?: 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <button type="button" onclick="removeProduct(this)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                {{-- Visibility Card --}}
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-6 italic">Configuration</h4>
                    
                    <div class="space-y-6">
                        <label class="flex items-center cursor-pointer gap-4 p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition-all hover:bg-white group/status">
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $collection->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-gray-700 group-hover/status:text-violet-600 transition-colors">Visible in Store</span>
                        </label>

                        <div class="p-6 bg-violet-600 rounded-3xl text-white shadow-xl shadow-violet-500/10">
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-violet-200 mb-2">Internal Status</h4>
                            <div class="text-xl font-black italic tracking-tighter uppercase">{{ $collection->is_active ? 'Active' : 'Draft' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Context Information --}}
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-violet-600/20 rounded-full blur-3xl"></div>
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/40 mb-4">Registry Summary</h4>
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/60">Registry Count</span>
                            <span class="text-sm font-black">{{ $collection->products->count() }} Products</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white/60">Last Updated</span>
                            <span class="text-sm font-black">{{ $collection->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('product-search');
        const resultsContainer = document.getElementById('search-results');
        const selectedContainer = document.getElementById('selected-products');
        const countSpan = document.getElementById('item-count');
        let timer;

        function updateCount() {
            countSpan.innerText = selectedContainer.querySelectorAll('[data-id]').length + ' Items';
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            const query = this.value;

            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }

            timer = setTimeout(() => {
                fetch(`{{ route('admin.products.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(products => {
                        resultsContainer.innerHTML = '';
                        if (products.length > 0) {
                            products.forEach(product => {
                                if (selectedContainer.querySelector(`[data-id="${product.id}"]`)) return;

                                const div = document.createElement('div');
                                div.className = 'p-4 hover:bg-gray-50 cursor-pointer flex items-center gap-4 transition-all group/res';
                                div.innerHTML = `
                                    <div class="w-10 h-10 rounded-xl overflow-hidden border border-gray-100 flex-shrink-0">
                                        ${product.image_url 
                                            ? `<img src="${product.image_url}" class="w-full h-full object-cover">` 
                                            : `<div class="w-full h-full bg-gray-100 flex items-center justify-center text-[8px] font-black text-gray-300">NO IMG</div>`}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-gray-900 group-hover/res:text-violet-600 transition-colors">${product.name}</span>
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest italic">${product.sku || 'No SKU'}</span>
                                    </div>
                                `;
                                div.onclick = () => addProduct(product);
                                resultsContainer.appendChild(div);
                            });
                            resultsContainer.classList.remove('hidden');
                        } else {
                            resultsContainer.classList.add('hidden');
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.classList.add('hidden');
            }
        });

        window.addProduct = function(product) {
            const container = document.getElementById('selected-products');
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 group/product hover:bg-white hover:shadow-md transition-all';
            div.dataset.id = product.id;
            
            div.innerHTML = `
                <div class="flex items-center gap-4">
                    <input type="hidden" name="products[]" value="${product.id}">
                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-white border border-gray-100 flex-shrink-0">
                        ${product.image_url 
                            ? `<img src="${product.image_url}" class="w-full h-full object-cover">` 
                            : `<div class="w-full h-full flex items-center justify-center bg-gray-100 text-[10px] font-black text-gray-300 uppercase">NO IMG</div>`}
                    </div>
                    <div>
                        <span class="text-sm font-black text-gray-900 line-clamp-1 tracking-tight">${product.name}</span>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">SKU: ${product.sku || 'N/A'}</span>
                    </div>
                </div>
                <button type="button" onclick="removeProduct(this)" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
            
            container.appendChild(div);
            searchInput.value = '';
            resultsContainer.classList.add('hidden');
            updateCount();
        };

        window.removeProduct = function(btn) {
            btn.closest('div').remove();
            updateCount();
        };
    });
</script>
@endpush
@endsection