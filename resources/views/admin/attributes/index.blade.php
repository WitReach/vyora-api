@extends('layouts.admin')

@section('header', 'Product Attributes')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Metadata Management</h1>
        <div class="bg-gray-200 p-1 rounded-lg flex space-x-1">
            <button class="tab-button px-4 py-1.5 text-xs font-bold rounded-md" data-tab="colors">Colors</button>
            <button class="tab-button px-4 py-1.5 text-xs font-bold rounded-md" data-tab="sizes">Sizes</button>
            <button class="tab-button px-4 py-1.5 text-xs font-bold rounded-md" data-tab="hsn">HSN Types</button>
            <button class="tab-button px-4 py-1.5 text-xs font-bold rounded-md" data-tab="size-chart">Size Charts</button>
        </div>
    </div>

    <!-- Colors Section -->
    <div id="tab-colors" class="tab-content grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold mb-4" id="color-form-title">Add New Color</h3>
                <form id="form-colors" action="{{ route('admin.attributes.colors.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Color Name</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Hex Code</label>
                        <input type="text" name="hex_code" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black" placeholder="#000000">
                    </div>
                    <button type="submit" id="btn-save-colors" class="w-full bg-black text-white py-2 rounded-lg text-sm font-bold">Save Color</button>
                    <button type="button" id="btn-cancel-colors" onclick="cancelEditColor()" class="hidden w-full bg-gray-100 text-gray-600 py-2 rounded-lg text-sm font-bold">Cancel</button>
                </form>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100 font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Hex</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($colors as $color)
                            <tr>
                                <td class="px-6 py-3 font-bold">
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded shadow-sm border border-gray-200" style="background-color: {{ $color->hex_code }}"></div>
                                        {{ $color->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-gray-500 font-mono">{{ $color->hex_code }}</td>
                                <td class="px-6 py-3 text-right">
                                    <button onclick="editColor('{{ route('admin.attributes.colors.update', $color->id) }}', '{{ addslashes($color->name) }}', '{{ $color->hex_code }}')" class="text-blue-600 hover:underline mr-3 text-xs font-bold">Edit</button>
                                    <form action="{{ route('admin.attributes.colors.destroy', $color) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs font-bold" onclick="return confirm('Delete color?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sizes Section -->
    <div id="tab-sizes" class="tab-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold mb-4" id="size-form-title">Add New Size</h3>
                <form id="form-sizes" action="{{ route('admin.attributes.sizes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Size Name</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Code</label>
                        <input type="text" name="code" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black" placeholder="XL">
                    </div>
                    <button type="submit" id="btn-save-sizes" class="w-full bg-black text-white py-2 rounded-lg text-sm font-bold">Save Size</button>
                </form>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100 font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Code</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($sizes as $size)
                            <tr>
                                <td class="px-6 py-3 font-bold">{{ $size->name }}</td>
                                <td class="px-6 py-3 text-gray-500 font-mono">{{ $size->code }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('admin.attributes.sizes.destroy', $size) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs font-bold" onclick="return confirm('Delete size?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- HSN Section -->
    <div id="tab-hsn" class="tab-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="font-bold mb-4">Add Product Type (HSN)</h3>
                <form action="{{ route('admin.attributes.types.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Type Name</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">HSN Code</label>
                        <input type="text" name="hsn_code" required class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-black focus:border-black">
                    </div>
                    <button type="submit" class="w-full bg-black text-white py-2 rounded-lg text-sm font-bold">Save Type</button>
                </form>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100 font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-3">Type Name</th>
                            <th class="px-6 py-3">HSN Code</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($types as $type)
                            <tr>
                                <td class="px-6 py-3 font-bold">{{ $type->name }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ $type->hsn_code }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('admin.attributes.types.destroy', $type) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-xs font-bold" onclick="return confirm('Delete type?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Size Chart Section -->
    <div id="tab-size-chart" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold">Size Charts</h3>
                <a href="{{ route('admin.size-charts.create') }}" class="px-4 py-2 bg-black text-white rounded-lg text-sm font-bold">Add Chart</a>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-100 font-bold text-gray-500">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Assignments</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($sizeCharts as $chart)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $chart->name }}</td>
                            <td class="px-6 py-4">{{ $chart->products_count }} Products</td>
                            <td class="px-6 py-4">
                                @if($chart->is_active)
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded">Active</span>
                                @else
                                    <span class="px-2 py-0.5 bg-gray-100 text-gray-400 text-[10px] font-bold uppercase rounded">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.size-charts.edit', $chart) }}" class="text-blue-600 hover:underline mr-3 text-xs font-bold">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                btn.classList.toggle('bg-white', btn.dataset.tab === tabName);
                btn.classList.toggle('shadow-sm', btn.dataset.tab === tabName);
                btn.classList.toggle('text-gray-500', btn.dataset.tab !== tabName);
            });
            tabContents.forEach(c => c.classList.toggle('hidden', c.id !== `tab-${tabName}`));
        }

        tabButtons.forEach(b => b.addEventListener('click', () => activateTab(b.dataset.tab)));
        activateTab('colors');
    });

    function editColor(url, name, hex) {
        const form = document.getElementById('form-colors');
        form.action = url;
        if (!form.querySelector('input[name="_method"]')) {
            const m = document.createElement('input'); m.type='hidden'; m.name='_method'; m.value='PUT'; form.appendChild(m);
        }
        form.querySelector('input[name="name"]').value = name;
        form.querySelector('input[name="hex_code"]').value = hex;
        document.getElementById('btn-save-colors').innerText = 'Update Color';
        document.getElementById('btn-cancel-colors').classList.remove('hidden');
    }

    function cancelEditColor() {
        const form = document.getElementById('form-colors');
        form.action = "{{ route('admin.attributes.colors.store') }}";
        const m = form.querySelector('input[name="_method"]'); if(m) m.remove();
        form.reset();
        document.getElementById('btn-save-colors').innerText = 'Save Color';
        document.getElementById('btn-cancel-colors').classList.add('hidden');
    }
</script>
@endpush
@endsection