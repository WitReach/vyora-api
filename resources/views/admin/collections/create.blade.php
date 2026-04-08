@extends('layouts.admin')

@section('header', 'New Collection')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Add Collection</h1>
        </div>
        
        <div class="flex items-center gap-4">
             <a href="{{ route('admin.collections.index') }}" class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 hover:bg-white transition-all">Cancel</a>
             <button type="submit" form="create-collection-form" class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                Create Collection
            </button>
        </div>
    </div>

    <form id="create-collection-form" action="{{ route('admin.collections.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            {{-- Main Column --}}
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest mb-10 flex items-center gap-3">
                         <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                         General Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Collection Name</label>
                            <input type="text" name="name" id="name" required placeholder="e.g. Winter Sale"
                                class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-violet-500 transition-all text-lg tracking-tight"
                                onkeyup="document.getElementById('slug').value = this.value.toLowerCase().trim().replace(/ /g, '-').replace(/[^\w-]+/g, '');">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Slug</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">/</span>
                                </div>
                                <input type="text" name="slug" id="slug" required placeholder="winter-sale"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 pl-8 pr-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all font-mono italic">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                             <label class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Brief Description</label>
                             <textarea name="description" rows="4" placeholder="Describe the theme and purpose of this collection..."
                                 class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl p-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all resize-none leading-relaxed"></textarea>
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
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600"></div>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest text-gray-700 group-hover/status:text-violet-600 transition-colors">Visible in Store</span>
                        </label>
                        
                        <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100 border-dashed">
                            <p class="text-[10px] font-medium text-gray-400 leading-relaxed italic">Products can be assigned to the collection after it has been initialized in the system.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection