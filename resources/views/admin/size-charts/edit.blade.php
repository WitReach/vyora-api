@extends('layouts.admin')

@section('header', 'Edit Size Chart')

@section('content')
<div class="w-full pb-24">
    <form action="{{ route('admin.size-charts.update', $sizeChart) }}" method="POST" id="size-chart-form">
        @csrf
        @method('PUT')

        {{-- Top Action Bar --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Edit Size Chart</h1>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.size-charts.index') }}" 
                    class="bg-white text-gray-900 border border-gray-200 px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-sm hover:bg-gray-50 transition-all">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-black text-white px-10 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 transition-all">
                    Update Size Chart
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2 space-y-10">
                {{-- Master Configuration Card --}}
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-1.5 h-10 bg-violet-600 rounded-full shadow-[0_0_15px_rgba(124,58,237,0.3)]"></div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Size Chart Table</h3>
                        </div>
                    </div>

                    <div class="space-y-12">
                        {{-- Measurement Columns Builder --}}
                        <div class="bg-gray-50/50 rounded-[2rem] border border-gray-100 p-8">
                            <div class="flex items-center justify-between mb-8">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Measurement Columns</label>
                                <button type="button" onclick="addColumn()" class="text-[10px] font-black uppercase tracking-widest text-violet-600 hover:text-violet-800 flex items-center gap-2">
                                    <span class="text-base leading-none">+</span> Add Column
                                </button>
                            </div>
                            
                            <div id="measurement-columns" class="flex flex-wrap gap-3">
                                @foreach($sizeChart->data->table_data['headers'] ?? [] as $header)
                                    <div class="measurement-column group flex items-center bg-white pl-5 pr-3 py-2.5 rounded-xl border border-gray-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-violet-500">
                                        <input type="text" value="{{ $header }}"
                                            class="column-name-input border-0 bg-transparent p-0 focus:ring-0 text-sm font-bold text-gray-900 w-24"
                                            placeholder="Label">
                                        <button type="button" onclick="removeColumn(this)"
                                            class="ml-3 text-gray-300 hover:text-red-500 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Main Table Builder --}}
                        <div class="overflow-x-auto -mx-2">
                            <table class="w-full text-left border-separate border-spacing-y-2" id="size-table">
                                <thead>
                                    <tr class="bg-gray-50/30">
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 rounded-l-2xl">Size Code</th>
                                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Size Name</th>
                                        @foreach($sizeChart->data->table_data['headers'] ?? [] as $header)
                                            <th class="measurements-header px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">{{ $header }}</th>
                                        @endforeach
                                        <th class="px-6 py-4 text-right rounded-r-2xl"></th>
                                    </tr>
                                </thead>
                                <tbody id="size-rows" class="before:block before:h-2">
                                    @foreach($sizeChart->data->table_data['rows'] ?? [] as $row)
                                        <tr class="size-row group">
                                            <td class="px-6 py-4 bg-gray-50/30 rounded-l-2xl border-y border-l border-gray-50 group-hover:bg-gray-50 transition-colors">
                                                <select class="size-code block w-full bg-white border-gray-100 rounded-xl py-2 px-3 text-xs font-bold focus:ring-2 focus:ring-violet-500" onchange="updateSizeName(this)">
                                                    <option value="">Select</option>
                                                    @foreach($sizes as $size)
                                                        <option value="{{ $size->code }}" data-name="{{ $size->name }}" {{ ($row['size_code'] ?? '') == $size->code ? 'selected' : '' }}>
                                                            {{ $size->code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-6 py-4 bg-gray-50/30 border-y border-gray-50 group-hover:bg-gray-50 transition-colors">
                                                <input type="text" class="size-name block w-full bg-transparent border-0 p-0 text-xs font-bold text-gray-400 uppercase tracking-widest" value="{{ $row['size_name'] }}" readonly placeholder="Size Name">
                                            </td>
                                            @foreach($sizeChart->data->table_data['headers'] ?? [] as $header)
                                                <td class="measurements px-6 py-4 bg-gray-50/30 border-y border-gray-50 group-hover:bg-gray-50 transition-colors text-center">
                                                    <input type="number" step="0.1"
                                                        class="measurement w-16 bg-white border-gray-100 rounded-xl py-2 px-3 text-xs font-bold text-center focus:ring-2 focus:ring-violet-500"
                                                        value="{{ $row['measurements'][$header] ?? 0 }}">
                                                </td>
                                            @endforeach
                                            <td class="px-6 py-4 bg-gray-50/30 rounded-r-2xl border-y border-r border-gray-50 group-hover:bg-gray-50 transition-colors text-right">
                                                <button type="button" onclick="removeRow(this)" class="p-2 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="button" onclick="addRow()" class="w-full py-4 border-2 border-dashed border-gray-100 rounded-3xl text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:border-violet-300 hover:bg-violet-50/10 hover:text-violet-600 transition-all">
                            + Add Size Row
                        </button>
                    </div>

                    <input type="hidden" name="table_data" id="table-data-input">
                </div>
            </div>

            <div class="space-y-10">
                {{-- Metadata Card --}}
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                    <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-10 italic">Basic Information</h4>
                    <div class="space-y-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Chart Name</label>
                            <input type="text" name="name" value="{{ $sizeChart->name }}" required
                                class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Default Unit</label>
                            <select name="unit" required
                                class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all">
                                <option value="inches" {{ $sizeChart->data->unit == 'inches' ? 'selected' : '' }}>Inches</option>
                                <option value="cm" {{ $sizeChart->data->unit == 'cm' ? 'selected' : '' }}>Centimeters</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3">Description</label>
                            <textarea name="description" rows="3"
                                class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all placeholder:text-gray-300" 
                                placeholder="Public notes for customers...">{{ $sizeChart->description }}</textarea>
                        </div>

                        <div class="pt-4">
                            <label class="relative flex items-center cursor-pointer group">
                                <input type="checkbox" name="is_active" value="1" {{ $sizeChart->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-8 bg-gray-100 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-violet-600"></div>
                                <span class="ml-4 text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-gray-900 transition-colors">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Linked Products Card --}}
                <div class="bg-black rounded-[2.5rem] p-10 text-white overflow-hidden relative group shadow-2xl">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-violet-600/20 blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-2 h-2 rounded-full bg-violet-400"></div>
                            <h5 class="text-[10px] font-black uppercase tracking-[0.2em] text-violet-300">Linked Products</h5>
                        </div>
                        <p class="text-4xl font-black mb-2">{{ $sizeChart->products->count() }}</p>
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Mapped Products</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const availableSizes = @json($sizes);

    function generateSizeOptions(selectedCode = null) {
        let options = '<option value="">Select</option>';
        availableSizes.forEach(size => {
            const selected = (size.code === selectedCode) ? 'selected' : '';
            options += `<option value="${size.code}" data-name="${size.name}" ${selected}>${size.code}</option>`;
        });
        return options;
    }

    function getColumns() {
        return Array.from(document.querySelectorAll('.column-name-input')).map(input => input.value.trim()).filter(v => v);
    }

    function addColumn() {
        const container = document.getElementById('measurement-columns');
        const div = document.createElement('div');
        div.className = 'measurement-column group flex items-center bg-white pl-5 pr-3 py-2.5 rounded-xl border border-gray-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-violet-500';
        div.innerHTML = `
            <input type="text" class="column-name-input border-0 bg-transparent p-0 focus:ring-0 text-sm font-bold text-gray-900 w-24" placeholder="Label">
            <button type="button" onclick="removeColumn(this)" class="ml-3 text-gray-300 hover:text-red-500 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
        container.appendChild(div);
        updateTableHeaders();
    }

    function removeColumn(btn) {
        if (document.querySelectorAll('.measurement-column').length <= 1) {
            alert('Core protocol requires at least one measurement parameter.');
            return;
        }
        btn.closest('.measurement-column').remove();
        updateTableHeaders();
    }

    function updateTableHeaders() {
        const columns = getColumns();
        const thead = document.querySelector('#size-table thead tr');
        thead.querySelectorAll('.measurements-header').forEach(th => th.remove());
        const actionsHeader = thead.querySelector('th:last-child');
        columns.forEach(col => {
            const th = document.createElement('th');
            th.className = 'measurements-header px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center';
            th.textContent = col;
            thead.insertBefore(th, actionsHeader);
        });

        document.querySelectorAll('.size-row').forEach(row => {
            row.querySelectorAll('.measurements').forEach(td => td.remove());
            const actionsTd = row.querySelector('td:last-child');
            columns.forEach(() => {
                const td = document.createElement('td');
                td.className = 'measurements px-6 py-4 bg-gray-50/30 border-y border-gray-50 group-hover:bg-gray-50 transition-colors text-center';
                td.innerHTML = '<input type="number" step="0.1" class="measurement w-16 bg-white border-gray-100 rounded-xl py-2 px-3 text-xs font-bold text-center focus:ring-2 focus:ring-violet-500" placeholder="0">';
                row.insertBefore(td, actionsTd);
            });
        });
    }

    function addRow() {
        const tbody = document.getElementById('size-rows');
        const columns = getColumns();
        const tr = document.createElement('tr');
        tr.className = 'size-row group';

        let html = `
            <td class="px-6 py-4 bg-gray-50/30 rounded-l-2xl border-y border-l border-gray-50 group-hover:bg-gray-50 transition-colors">
                <select class="size-code block w-full bg-white border-gray-100 rounded-xl py-2 px-3 text-xs font-bold focus:ring-2 focus:ring-violet-500" onchange="updateSizeName(this)">
                    ${generateSizeOptions()}
                </select>
            </td>
            <td class="px-6 py-4 bg-gray-50/30 border-y border-gray-50 group-hover:bg-gray-50 transition-colors">
                <input type="text" class="size-name block w-full bg-transparent border-0 p-0 text-xs font-bold text-gray-400 uppercase tracking-widest" placeholder="NAME" readonly>
            </td>
        `;
        columns.forEach(() => {
            html += '<td class="measurements px-6 py-4 bg-gray-50/30 border-y border-gray-50 group-hover:bg-gray-50 transition-colors text-center"><input type="number" step="0.1" class="measurement w-16 bg-white border-gray-100 rounded-xl py-2 px-3 text-xs font-bold text-center focus:ring-2 focus:ring-violet-500" placeholder="0"></td>';
        });
        html += `
            <td class="px-6 py-4 bg-gray-50/30 rounded-r-2xl border-y border-r border-gray-50 group-hover:bg-gray-50 transition-colors text-right">
                <button type="button" onclick="removeRow(this)" class="p-2 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </td>
        `;
        tr.innerHTML = html;
        tbody.appendChild(tr);
    }

    function updateSizeName(select) {
        const option = select.options[select.selectedIndex];
        const row = select.closest('tr');
        const nameInput = row.querySelector('.size-name');
        if (option.value) {
            nameInput.value = option.dataset.name;
        } else {
            nameInput.value = '';
        }
    }

    function removeRow(btn) {
        if (document.querySelectorAll('.size-row').length <= 1) {
            alert('At least one size node must exist in the schema.');
            return;
        }
        btn.closest('.size-row').remove();
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('column-name-input')) {
            updateTableHeaders();
        }
    });

    document.getElementById('size-chart-form').addEventListener('submit', function (e) {
        const columns = getColumns();
        const rows = [];
        let hasError = false;

        document.querySelectorAll('.size-row').forEach(row => {
            const sizeCode = row.querySelector('.size-code').value.trim();
            const sizeName = row.querySelector('.size-name').value.trim();
            const measurements = {};

            if (!sizeCode) {
                hasError = true;
                row.querySelector('.size-code').classList.add('ring-2', 'ring-red-500');
            } else {
                row.querySelector('.size-code').classList.remove('ring-2', 'ring-red-500');
            }

            const measurementInputs = row.querySelectorAll('.measurement');
            columns.forEach((col, index) => {
                measurements[col] = parseFloat(measurementInputs[index].value) || 0;
            });

            if (sizeCode) {
                rows.push({
                    size_code: sizeCode,
                    size_name: sizeName,
                    measurements: measurements
                });
            }
        });

        if (hasError) {
            e.preventDefault();
            alert('Selection required for all active size slots.');
            return;
        }

        const tableData = {
            headers: columns,
            rows: rows
        };

        document.getElementById('table-data-input').value = JSON.stringify(tableData);
    });
</script>
@endpush
@endsection