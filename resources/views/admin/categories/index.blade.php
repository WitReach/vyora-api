@extends('layouts.admin')

@section('header', 'Categories Hierarchy')

@section('content')
<div class="w-full">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Categories</h1>
        </div>
        
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all flex items-center gap-3">
            <span class="text-lg leading-none">+</span>
            New Category
        </a>
    </div>

    {{-- Stats Row (Full Width) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Total Categories</span>
                <div class="p-2 bg-gray-50 rounded-xl text-gray-400 group-hover:bg-black group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-gray-900 tracking-tight">{{ number_format($stats['total']) }}</h4>
        </div>

        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Active Nodes</span>
                <div class="p-2 bg-green-50 rounded-xl text-green-500 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-green-600 tracking-tight">{{ number_format($stats['active']) }}</h4>
        </div>

        <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 hover:shadow-xl hover:shadow-gray-200/20 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 italic">Root Hierarchy</span>
                <div class="p-2 bg-violet-50 rounded-xl text-violet-500 group-hover:bg-violet-600 group-hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 002-2h2a2 2 0 002 2h4a2 2 0 012 2v12a4 4 0 01-4 4h-12z"></path></svg>
                </div>
            </div>
            <h4 class="text-4xl font-black text-violet-600 tracking-tight">{{ number_format($stats['root']) }}</h4>
        </div>
    </div>

    {{-- Main Hierarchy Card (Full Width) --}}
    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
        <div class="flex items-center justify-between mb-10 border-b border-gray-50 pb-8">
             <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.3em] flex items-center gap-3">
                 <div class="w-1.5 h-1.5 bg-black rotate-45"></div>
                 Structural Flow
             </h3>
             <div class="text-[10px] font-black text-gray-300 uppercase tracking-widest italic">Drag handles to reorder nodes</div>
        </div>

        <ul class="space-y-4 sortable-list" id="root-categories" data-parent-id="">
            @foreach($categories as $category)
                @include('admin.categories.item', ['category' => $category, 'level' => 0])
            @endforeach
        </ul>

        @if($categories->isEmpty())
            <div class="py-24 text-center">
                 <div class="w-16 h-16 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-4 text-gray-200">
                     <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                 </div>
                 <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Catalog empty</h4>
                 <p class="text-xs font-medium text-gray-400 mt-1 italic">Start by creating your first category above.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function initSortable() {
            var nestedSortables = [].slice.call(document.querySelectorAll('.sortable-list'));
            for (var i = 0; i < nestedSortables.length; i++) {
                new Sortable(nestedSortables[i], {
                    group: 'nested',
                    animation: 250,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    handle: '.drag-handle',
                    ghostClass: 'opacity-10',
                    chosenClass: 'scale-[0.98]',
                    dragClass: 'shadow-2xl',
                    onEnd: function (evt) {
                        saveOrder();
                    }
                });
            }
        }

        initSortable();

        function getOrder(rootElement) {
            let result = [];
            Array.from(rootElement.children).forEach(li => {
                if (li.tagName === 'LI') {
                    let item = { id: li.dataset.id };
                    let childUl = li.querySelector('ul.sortable-list');
                    if (childUl) {
                        item.children = getOrder(childUl);
                    }
                    result.push(item);
                }
            });
            return result;
        }

        function saveOrder() {
            const root = document.getElementById('root-categories');
            const order = getOrder(root);

            fetch('{{ route('admin.categories.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ categories: order })
            })
            .then(res => res.json())
            .then(data => { console.log('Hierarchy Persisted'); })
            .catch(error => alert('Sync Failed: ' + error));
        }
    });
</script>
@endpush
@endsection