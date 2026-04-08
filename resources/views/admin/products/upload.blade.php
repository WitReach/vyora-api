@extends('layouts.admin')

@section('header', 'Bulk Upload')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Bulk Import Items</h1>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="bg-gray-100 p-1.5 rounded-2xl flex items-center shadow-sm border border-gray-200/50">
                <button onclick="switchTab('general')" id="tab-general"
                    class="px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all {{ !request('tab') || request('tab') === 'general' ? 'bg-black text-white shadow-xl' : 'text-gray-500 hover:text-gray-900' }}">
                    General
                </button>
                <button onclick="switchTab('qikink')" id="tab-qikink"
                    class="px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all {{ request('tab') === 'qikink' ? 'bg-black text-white shadow-xl' : 'text-gray-500 hover:text-gray-900' }}">
                    QikInk
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Main Upload Area --}}
        <div class="lg:col-span-2">
            <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10 min-h-[500px]">
                
                {{-- GENERAL FORM --}}
                <div id="content-general" class="{{ request('tab') === 'qikink' ? 'hidden' : '' }}">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-1.5 h-10 bg-violet-600 rounded-full shadow-[0_0_15px_rgba(124,58,237,0.3)]"></div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Standard Importer</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">Full Catalog Registry with SEO and Logistics</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
                        @csrf
                        <input type="hidden" name="type" value="general">

                        <div id="dropzone-general" class="group relative flex flex-col items-center justify-center min-h-[320px] px-10 py-12 border-2 border-dashed border-gray-100 rounded-[2.5rem] hover:border-violet-500 hover:bg-violet-50/10 transition-all duration-500 cursor-pointer shadow-sm">
                            <input name="file" type="file" id="input-general" class="sr-only" accept=".csv">
                            
                            <div class="dz-initial space-y-6 text-center">
                                <div class="mx-auto w-20 h-20 bg-gray-50 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-center group-hover:bg-black group-hover:scale-110 transition-all duration-500 group-hover:shadow-2xl">
                                    <svg class="w-8 h-8 text-violet-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base font-black text-gray-900 uppercase tracking-tight">Stream data items onto storefront</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 italic">Accepts CSV, TXT (Maximum throughput 10MB)</p>
                                </div>
                            </div>

                            <div class="dz-preview hidden w-full space-y-6 text-center">
                                <div class="mx-auto w-20 h-20 bg-green-50 rounded-[2rem] shadow-sm border border-green-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="file-name text-lg font-black text-gray-900 truncate px-10 tracking-tight"></p>
                                    <p class="file-size text-[10px] text-green-600 font-black uppercase tracking-widest mt-2"></p>
                                </div>
                                <button type="button" onclick="resetFileInput('general')" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors">Discard Channel</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-6 pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-3 px-6 py-3 bg-violet-50/50 rounded-2xl text-[10px] font-black text-violet-700 uppercase tracking-widest italic border border-violet-100/50">
                                <div class="w-1.5 h-1.5 rounded-full bg-violet-500"></div>
                                Validate HSN and Tax columns before proceeding
                            </div>
                            <button type="submit" class="bg-black text-white px-10 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                                Execute Import Session
                            </button>
                        </div>
                    </form>
                </div>

                {{-- QIKINK FORM --}}
                <div id="content-qikink" class="{{ request('tab') === 'qikink' ? '' : 'hidden' }}">
                    <div class="flex items-center gap-6 mb-12">
                        <div class="w-1.5 h-10 bg-black rounded-full shadow-sm"></div>
                        <div>
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Variant Automator</h3>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1 italic">Intelligent Parsing for Managed QikInk Feeds</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-12">
                        @csrf
                        <input type="hidden" name="type" value="qikink">

                        <div id="dropzone-qikink" class="group relative flex flex-col items-center justify-center min-h-[320px] px-10 py-12 border-2 border-dashed border-gray-100 rounded-[2.5rem] hover:border-black hover:bg-gray-50/50 transition-all duration-500 cursor-pointer shadow-sm">
                            <input name="file" type="file" id="input-qikink" class="sr-only" accept=".csv">
                            
                            <div class="dz-initial space-y-6 text-center">
                                <div class="mx-auto w-20 h-20 bg-gray-50 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-center group-hover:bg-black group-hover:scale-110 transition-all duration-500 group-hover:shadow-2xl">
                                    <svg class="w-8 h-8 text-black group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-base font-black text-gray-900 uppercase tracking-tight">Upload raw QikInk signal feed</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-2 italic">Automatic variant grouping by Master Identifier</p>
                                </div>
                            </div>

                            <div class="dz-preview hidden w-full space-y-6 text-center">
                                <div class="mx-auto w-20 h-20 bg-green-50 rounded-[2rem] shadow-sm border border-green-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="max-w-xs mx-auto">
                                    <p class="file-name text-lg font-black text-gray-900 truncate px-10 tracking-tight"></p>
                                    <p class="file-size text-[10px] text-green-600 font-black uppercase tracking-widest mt-2"></p>
                                </div>
                                <button type="button" onclick="resetFileInput('qikink')" class="text-[10px] font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors">Discard Feed</button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-6 pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-3 px-6 py-3 bg-gray-50 rounded-2xl text-[10px] font-black text-gray-500 uppercase tracking-widest italic border border-gray-100">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400"></div>
                                Logic: Variants are merged via [Item Name]
                            </div>
                            <button type="submit" class="bg-black text-white px-10 py-4 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                                Execute QikInk Process
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- Sidebar Resources --}}
        <div class="space-y-8">
            <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8 overflow-hidden relative group">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-gray-50 rounded-full blur-3xl opacity-50 group-hover:scale-150 transition-transform duration-700"></div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-8 italic">Data Blueprints</h4>
                <div class="space-y-4">
                    <a href="{{ route('admin.upload.sample-general') }}" class="group flex items-center gap-4 p-5 bg-white border border-gray-50 rounded-3xl hover:border-violet-300 hover:shadow-xl hover:shadow-violet-500/5 transition-all duration-300">
                        <div class="bg-violet-50 p-3 rounded-2xl text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-black text-gray-900 tracking-tight leading-tight">Master Pattern</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">General Importer · CSV</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.upload.sample-qikink') }}" class="group flex items-center gap-4 p-5 bg-white border border-gray-50 rounded-3xl hover:border-black hover:shadow-xl hover:shadow-gray-200/5 transition-all duration-300">
                        <div class="bg-gray-50 p-3 rounded-2xl text-gray-400 group-hover:bg-black group-hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-black text-gray-900 tracking-tight leading-tight">QikInk Schema</p>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Raw Feed Pattern · CSV</p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-black rounded-[2.5rem] p-8 text-white overflow-hidden relative group shadow-2xl">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-violet-600/30 blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-2 h-2 rounded-full bg-violet-400 animate-pulse"></div>
                        <h5 class="text-[10px] font-black uppercase tracking-[0.2em] text-violet-300">Process Logic</h5>
                    </div>
                    <p class="text-xs font-bold leading-loose text-gray-400 italic">
                        "Products are clustered by <span class="text-white underline decoration-violet-500/50 decoration-2 underline-offset-4">NAME IDENTITY</span>. Ensuring consistent names within your CSV allows the system to build multi-variant hierarchies automatically."
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        ['general', 'qikink'].forEach(type => {
            const dropzone = document.getElementById(`dropzone-${type}`);
            const input = document.getElementById(`input-${type}`);

            if (dropzone && input) {
                dropzone.addEventListener('click', () => input.click());
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) handleFileSelect(type, file);
                });
                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.classList.add('border-violet-500', 'bg-violet-50/10');
                });
                dropzone.addEventListener('dragleave', () => {
                    dropzone.classList.remove('border-violet-500', 'bg-violet-50/10');
                });
                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('border-violet-500', 'bg-violet-50/10');
                    const file = e.dataTransfer.files[0];
                    if (file && (file.type === 'text/csv' || file.name.endsWith('.csv') || file.name.endsWith('.txt'))) {
                        input.files = e.dataTransfer.files;
                        handleFileSelect(type, file);
                    }
                });
            }
        });

        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab) switchTab(tab);
    });

    function handleFileSelect(type, file) {
        const dropzone = document.getElementById(`dropzone-${type}`);
        const initial = dropzone.querySelector('.dz-initial');
        const preview = dropzone.querySelector('.dz-preview');
        const nameEl = preview.querySelector('.file-name');
        const sizeEl = preview.querySelector('.file-size');

        initial.classList.add('hidden');
        preview.classList.remove('hidden');

        nameEl.innerText = file.name;
        sizeEl.innerText = (file.size / 1024).toFixed(1) + ' KB';

        dropzone.classList.remove('border-gray-100');
        dropzone.classList.add('border-green-400', 'bg-green-50/10');
    }

    function resetFileInput(type) {
        const dropzone = document.getElementById(`dropzone-${type}`);
        const input = document.getElementById(`input-${type}`);
        const initial = dropzone.querySelector('.dz-initial');
        const preview = dropzone.querySelector('.dz-preview');

        input.value = '';
        initial.classList.remove('hidden');
        preview.classList.add('hidden');

        dropzone.classList.add('border-gray-100');
        dropzone.classList.remove('border-green-400', 'bg-green-50/10');
    }

    function switchTab(type) {
        const url = new URL(window.location);
        url.searchParams.set('tab', type);
        window.history.pushState({}, '', url);

        document.getElementById('content-general').classList.toggle('hidden', type !== 'general');
        document.getElementById('content-qikink').classList.toggle('hidden', type !== 'qikink');

        const btnGen = document.getElementById('tab-general');
        const btnQik = document.getElementById('tab-qikink');

        if (type === 'general') {
            btnGen.className = "px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all bg-black text-white shadow-xl";
            btnQik.className = "px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-gray-900 rounded-xl transition-all";
        } else {
            btnQik.className = "px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-xl transition-all bg-black text-white shadow-xl";
            btnGen.className = "px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-gray-900 rounded-xl transition-all";
        }
    }
</script>
@endpush
@endsection