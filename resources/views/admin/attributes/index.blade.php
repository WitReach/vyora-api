@extends('layouts.admin')

@section('header', 'Attributes')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Product Metadata</h1>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="bg-gray-100 p-1.5 rounded-2xl flex items-center shadow-sm border border-gray-200/50">
                <button type="button" class="tab-button px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all" data-tab="colors">Colors</button>
                <button type="button" class="tab-button px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all" data-tab="sizes">Sizes</button>
                <button type="button" class="tab-button px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all" data-tab="hsn">Product HSN</button>
                <button type="button" class="tab-button px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all" data-tab="size-chart">Size Charts</button>
            </div>
        </div>
    </div>

    {{-- Main Activity Area --}}
    <div class="grid grid-cols-1 gap-10">
        
        {{-- COLORS SECTION --}}
        <div id="tab-colors" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-10 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                            Add Color
                        </h3>
                        <form id="form-colors" action="{{ route('admin.attributes.colors.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Color Name</label>
                                <input type="text" name="name" required placeholder="e.g. Royal Blue"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Hex Identifier</label>
                                <div class="relative">
                                    <input type="text" name="hex_code" required placeholder="#000000"
                                        class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                                </div>
                            </div>
                            <div class="pt-4 space-y-3">
                                <button type="submit" id="btn-save-colors" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 transition-all">Add Color</button>
                                <button type="button" id="btn-cancel-colors" onclick="cancelEditColor()" class="hidden w-full bg-gray-100 text-gray-500 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
                        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Color Registry</h3>
                            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest italic">{{ $colors->count() }} Definitions</span>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($colors as $color)
                                <div class="p-8 flex items-center justify-between hover:bg-gray-50/50 transition-all group">
                                    <div class="flex items-center gap-6">
                                        <div class="h-14 w-14 rounded-2xl border-4 border-white shadow-xl group-hover:scale-110 transition-transform duration-500"
                                            style="background-color: {{ $color->hex_code }}"></div>
                                        <div>
                                            <p class="text-base font-black text-gray-900 tracking-tight">{{ $color->name }}</p>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">{{ $color->hex_code }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-all">
                                        <button type="button" onclick="editColor('{{ route('admin.attributes.colors.update', $color->id) }}', '{{ addslashes($color->name) }}', '{{ $color->hex_code }}')"
                                            class="text-[10px] font-black uppercase tracking-widest text-violet-600 hover:bg-violet-50 px-4 py-2 rounded-lg">Edit</button>
                                        <form action="{{ route('admin.attributes.colors.destroy', $color) }}" method="POST" onsubmit="return confirm('Delete this color?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 px-4 py-2">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-20 text-center text-gray-300 italic">No color nodes present.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIZES SECTION --}}
        <div id="tab-sizes" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-10 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-black rounded-full"></div>
                            Add Size
                        </h3>
                        <form id="form-sizes" action="{{ route('admin.attributes.sizes.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Full Name</label>
                                <input type="text" name="name" required placeholder="e.g. Extra Large"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Code</label>
                                <input type="text" name="code" required placeholder="XL"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                            <div class="pt-4 space-y-3">
                                <button type="submit" id="btn-save-sizes" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl transition-all">Add Size</button>
                                <button type="button" id="btn-cancel-sizes" onclick="cancelEditSize()" class="hidden w-full bg-gray-100 text-gray-500 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
                        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Scale Hierarchy</h3>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($sizes as $size)
                                <div class="p-8 flex items-center justify-between hover:bg-gray-50/50 transition-all group">
                                    <div>
                                        <p class="text-base font-black text-gray-900 tracking-tight">{{ $size->name }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">CODE: {{ $size->code }}</p>
                                    </div>
                                    <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-all">
                                        <button type="button" onclick="editSize('{{ route('admin.attributes.sizes.update', $size->id) }}', '{{ addslashes($size->name) }}', '{{ addslashes($size->code) }}')"
                                            class="text-[10px] font-black uppercase tracking-widest text-violet-600 hover:bg-violet-50 px-4 py-2 rounded-lg">Edit</button>
                                        <form action="{{ route('admin.attributes.sizes.destroy', $size) }}" method="POST" onsubmit="return confirm('Delete this size?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 px-4 py-2">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-20 text-center text-gray-300 italic">No sizing nodes.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- HSN SECTION --}}
        <div id="tab-hsn" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em] mb-10 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-violet-600 rounded-full italic font-mono flex items-center justify-center text-[8px] text-white">T</div>
                            Add Type
                        </h3>
                        <form id="form-hsn" action="{{ route('admin.attributes.types.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">Identity Name</label>
                                <input type="text" name="name" required placeholder="e.g. T-Shirt"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 ml-1">HSN Classification</label>
                                <input type="text" name="hsn_code" required placeholder="6109"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                            </div>
                            <div class="pt-4 space-y-3">
                                <button type="submit" id="btn-save-hsn" class="w-full bg-black text-white py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl transition-all">Add Type</button>
                                <button type="button" id="btn-cancel-hsn" onclick="cancelEditHsn()" class="hidden w-full bg-gray-100 text-gray-500 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
                        <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Mapping Schema</h3>
                        </div>
                        <div class="divide-y divide-gray-50">
                            @forelse($types as $type)
                                <div class="p-8 flex items-center justify-between hover:bg-gray-50/50 transition-all group">
                                    <div>
                                        <p class="text-base font-black text-gray-900 tracking-tight">{{ $type->name }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">HSN: {{ $type->hsn_code }}</p>
                                    </div>
                                    <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-all">
                                        <button type="button" onclick="editHsn('{{ route('admin.attributes.types.update', $type->id) }}', '{{ addslashes($type->name) }}', '{{ addslashes($type->hsn_code) }}')"
                                            class="text-[10px] font-black uppercase tracking-widest text-violet-600 hover:bg-violet-50 px-4 py-2 rounded-lg">Edit</button>
                                        <form action="{{ route('admin.attributes.types.destroy', $type) }}" method="POST" onsubmit="return confirm('Delete this type?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600 px-4 py-2">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="p-20 text-center text-gray-300 italic">No types mapped.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIZE CHART SECTION --}}
        <div id="tab-size-chart" class="tab-content hidden">
            <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
                <div class="p-10 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                    <div>
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-[0.2em]">Structural Sizing Charts</h3>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">Flexible measurement matrices for customer guidance</p>
                    </div>
                    <a href="{{ route('admin.size-charts.create') }}"
                        class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 transition-all">
                        Add Chart
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Schema Identity</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Assignment Count</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Channel Status</th>
                                <th class="px-10 py-6 text-right text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($sizeCharts as $chart)
                                <tr class="group hover:bg-gray-50/50 transition-all">
                                    <td class="px-10 py-8">
                                        <div class="text-base font-black text-gray-900 tracking-tight">{{ $chart->name }}</div>
                                        @if($chart->description)
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic mt-1">{{ Str::limit($chart->description, 60) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-10 py-8">
                                        <span class="text-sm font-black text-gray-900 bg-gray-100 px-3 py-1 rounded-lg">{{ $chart->products_count }} Items</span>
                                    </td>
                                    <td class="px-10 py-8">
                                        @if($chart->is_active)
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-green-50 text-green-600 border border-green-100">
                                                <div class="w-1 h-1 rounded-full bg-green-500"></div> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-gray-50 text-gray-400 border border-gray-100">
                                                <div class="w-1 h-1 rounded-full bg-gray-300"></div> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-8 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-4 opacity-0 group-hover:opacity-100 transition-all">
                                            <a href="{{ route('admin.size-charts.edit', $chart) }}"
                                                class="text-[10px] font-black uppercase tracking-widest text-violet-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.size-charts.destroy', $chart) }}" method="POST" onsubmit="return confirm('Delete this chart?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-red-400 hover:text-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center text-gray-300 italic">No structural charts defined.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function activateTab(tabName) {
            tabButtons.forEach(btn => {
                btn.classList.remove('bg-black', 'text-white', 'shadow-xl');
                btn.classList.add('text-gray-500', 'hover:text-gray-900');
                if (btn.dataset.tab === tabName) {
                    btn.classList.remove('text-gray-500', 'hover:text-gray-900');
                    btn.classList.add('bg-black', 'text-white', 'shadow-xl');
                }
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.id !== `tab-${tabName}`);
            });
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetTab = button.dataset.tab;
                activateTab(targetTab);
                history.pushState(null, null, `#${targetTab}`);
            });
        });

        const hash = window.location.hash.substring(1);
        activateTab(hash && document.querySelector(`.tab-button[data-tab="${hash}"]`) ? hash : 'colors');
    });

    function addMethodInput(form) {
        if (!form.querySelector('input[name="_method"]')) {
            const input = document.createElement('input');
            input.type = 'hidden'; input.name = '_method'; input.value = 'PUT';
            form.appendChild(input);
        }
    }

    function removeMethodInput(form) {
        const input = form.querySelector('input[name="_method"]');
        if (input) input.remove();
    }

    function editColor(url, name, hex) {
        const form = document.getElementById('form-colors');
        form.action = url; addMethodInput(form);
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="hex_code"]').value = hex;
        document.getElementById('btn-save-colors').innerText = 'Update Color';
        document.getElementById('btn-cancel-colors').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function cancelEditColor() {
        const form = document.getElementById('form-colors');
        form.action = "{{ route('admin.attributes.colors.store') }}";
        removeMethodInput(form); form.reset();
        document.getElementById('btn-save-colors').innerText = 'Add Color';
        document.getElementById('btn-cancel-colors').classList.add('hidden');
    }

    function editSize(url, name, code) {
        const form = document.getElementById('form-sizes');
        form.action = url; addMethodInput(form);
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="code"]').value = code;
        document.getElementById('btn-save-sizes').innerText = 'Update Size';
        document.getElementById('btn-cancel-sizes').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function cancelEditSize() {
        const form = document.getElementById('form-sizes');
        form.action = "{{ route('admin.attributes.sizes.store') }}";
        removeMethodInput(form); form.reset();
        document.getElementById('btn-save-sizes').innerText = 'Add Size';
        document.getElementById('btn-cancel-sizes').classList.add('hidden');
    }

    function editHsn(url, name, code) {
        const form = document.getElementById('form-hsn');
        form.action = url; addMethodInput(form);
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="hsn_code"]').value = code;
        document.getElementById('btn-save-hsn').innerText = 'Update Type';
        document.getElementById('btn-cancel-hsn').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function cancelEditHsn() {
        const form = document.getElementById('form-hsn');
        form.action = "{{ route('admin.attributes.types.store') }}";
        removeMethodInput(form); form.reset();
        document.getElementById('btn-save-hsn').innerText = 'Add Type';
        document.getElementById('btn-cancel-hsn').classList.add('hidden');
    }
</script>
@endpush
@endsection