@extends('layouts.admin')

@section('header', 'Products')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Products Inventory</h1>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.create') }}" 
                class="bg-white text-gray-900 border border-gray-200 px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-sm hover:bg-gray-50 transition-all">
                Add New Product
            </a>
            <a href="{{ route('admin.upload') }}" 
                class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 transition-all">
                Bulk Upload
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Total Items</span>
                <div class="p-2 bg-gray-50 rounded-xl text-gray-400 group-hover:bg-black group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-gray-900 tracking-tight">{{ number_format($stats['total']) }}</h4>
        </div>

        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Active</span>
                <div class="p-2 bg-green-50 rounded-xl text-green-500 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-green-600 tracking-tight">{{ number_format($stats['active']) }}</h4>
        </div>

        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Low Stock</span>
                <div class="p-2 bg-amber-50 rounded-xl text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-amber-500 tracking-tight">{{ number_format($stats['low_stock']) }}</h4>
        </div>

        <div class="bg-white shadow-[0_8_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Sold Out</span>
                <div class="p-2 bg-red-50 rounded-xl text-red-500 group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-red-600 tracking-tight">{{ number_format($stats['out_of_stock']) }}</h4>
        </div>
    </div>

    {{-- Data Table Section --}}
    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
        {{-- Table Filters --}}
        <div class="p-10 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-gray-50/30">
            <div class="relative w-full md:w-96 group">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-300 group-focus-within:text-violet-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="productSearch" placeholder="Filter by name or SKU..." 
                    class="block w-full pl-12 pr-6 py-4 bg-white border-0 ring-1 ring-inset ring-gray-100 rounded-2xl text-sm font-bold placeholder:text-gray-300 focus:ring-2 focus:ring-violet-500 transition-all shadow-sm">
            </div>
            
            <div class="flex items-center gap-6">
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 italic">
                    Displaying {{ $products->count() }} of {{ number_format($stats['total']) }} Items
                </span>
                <div class="h-8 w-px bg-gray-200"></div>
                <button class="p-3 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-gray-900 transition-all shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Product Concept</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Value</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Inventory</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Status</th>
                        <th class="px-10 py-6 text-right text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 whitespace-nowrap">Context Controls</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                        <tr class="group hover:bg-gray-50/80 transition-all duration-300">
                            <td class="px-10 py-7">
                                <div class="flex items-center gap-6">
                                    <div class="relative w-16 h-20 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-500">
                                        @if($product->preview_image)
                                            <img class="w-full h-full object-cover" src="/{{ $product->preview_image }}" alt="">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-200">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-base font-black text-gray-900 tracking-tight truncate max-w-[300px] mb-1.5">{{ $product->name }}</div>
                                        <div class="flex items-center gap-2.5">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-violet-600 bg-violet-50 px-2.5 py-1 rounded-lg">{{ $product->brand_name ?? 'Collection' }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter truncate italic">/ {{ $product->slug }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <div class="text-base font-black text-gray-900 tracking-tight">
                                    @if($product->skus->isNotEmpty())
                                        @php
                                            $minPrice = $product->skus->min('price');
                                            $maxPrice = $product->skus->max('price');
                                        @endphp
                                        ₹{{ number_format($minPrice, 0) }}
                                        @if($minPrice != $maxPrice)
                                            <span class="text-gray-300 mx-1">-</span> <span class="text-gray-400 text-xs">₹{{ number_format($maxPrice, 0) }}</span>
                                        @endif
                                    @else
                                        <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">No Price</span>
                                    @endif
                                </div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em] mt-1.5">
                                    {{ $product->skus->count() }} Variants
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $totalStock = $product->skus->sum('stock');
                                    $isLow = $product->skus->contains(fn($sku) => $sku->stock <= 5);
                                @endphp
                                <div class="flex items-center justify-center gap-2 mb-1.5">
                                    <span class="text-base font-black tracking-tight {{ $totalStock > 0 ? ($isLow ? 'text-amber-600' : 'text-gray-900') : 'text-red-500' }}">
                                        {{ number_format($totalStock, 0) }}
                                    </span>
                                    @if($isLow && $totalStock > 0)
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></div>
                                    @endif
                                </div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em]">UNIT STOCK</div>
                            </td>
                            <td class="px-8 py-7">
                                <div class="flex justify-center">
                                    @if($product->is_active)
                                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border-2 border-green-50 text-green-600 bg-white shadow-sm">
                                            <div class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.4)]"></div>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border-2 border-gray-50 text-gray-400 bg-white shadow-sm">
                                            <div class="w-1.5 h-1.5 rounded-full bg-gray-300"></div>
                                            Draft
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-10 py-7 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3 translate-x-2 opacity-10 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                        class="p-3 bg-white text-gray-400 hover:text-violet-600 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Archive this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-3 bg-white text-gray-400 hover:text-red-500 border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="w-24 h-24 bg-gray-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-gray-100/50">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <h4 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-2">Vault is Empty</h4>
                                    <p class="text-sm text-gray-400 font-medium mb-10 italic">No products matched your parameters. Start by defining your first master item.</p>
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{ route('admin.products.create') }}" class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-xl">Initiate Item</a>
                                        <a href="{{ route('admin.upload') }}" class="px-8 py-3.5 border border-gray-200 text-gray-900 font-black uppercase tracking-[0.2em] text-xs rounded-2xl hover:bg-gray-50 transition-all">Bulk Flow</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="p-10 border-t border-gray-50 bg-gray-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('productSearch');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase().trim();
        
        tableRows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;

            const name = row.querySelector('.text-base.font-black').innerText.toLowerCase();
            const slug = row.querySelector('.text-gray-400.italic').innerText.toLowerCase();
            
            if (name.includes(term) || slug.includes(term)) {
                row.style.display = '';
                row.classList.add('opacity-0');
                setTimeout(() => row.classList.remove('opacity-0'), 10);
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush
@endsection
