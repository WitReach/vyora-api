@extends('layouts.admin')

@section('header', 'Add Customise Page')

@section('content')
<div class="w-full pb-24">
    {{-- Header Section --}}
    <div class="mb-12 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-12 bg-black rounded-full shadow-[0_0_20px_rgba(0,0,0,0.1)]"></div>
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Add Customise Page</h1>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em] italic">Orchestrate your store experience</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.online-store.mnpages.index') }}"
                class="group flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                Cancel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.online-store.mnpages.store') }}" method="POST" id="page-form" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Left Column: Primary Config --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Basic Settings Card --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-10 shadow-[0_8px_40px_rgba(0,0,0,0.03)]">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Page Settings</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-10">
                        {{-- Title --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Page Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required
                                class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-black/5 focus:border-black transition-all outline-none"
                                placeholder="e.g., Summer Sale">
                        </div>

                        {{-- Slug --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Slug <span class="text-red-500">*</span></label>
                            <div class="flex items-center bg-white border border-gray-100 rounded-2xl overflow-hidden focus-within:ring-4 focus-within:ring-black/5 focus-within:border-black transition-all">
                                <span class="pl-6 pr-2 text-xs font-bold text-gray-400 opacity-50 uppercase tracking-tighter">{{ url('/pages/') }}/</span>
                                <input type="text" name="slug" id="slug" required
                                    class="flex-1 bg-transparent border-none px-0 py-4 text-sm font-bold text-gray-900 focus:ring-0"
                                    placeholder="e.g., summer-sale">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO Settings Card --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-10 shadow-[0_8px_40px_rgba(0,0,0,0.03)]">
                    <div class="flex items-center gap-3 mb-10 text-gray-400 group hover:text-black transition-colors">
                        <div class="w-1.5 h-6 bg-current rounded-full"></div>
                        <h3 class="text-xs font-black uppercase tracking-widest">SEO Settings</h3>
                    </div>

                    <div class="space-y-8">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Meta Title</label>
                            <input type="text" name="meta_title"
                                class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-black/5 focus:border-black transition-all outline-none"
                                placeholder="Use Page Title">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Meta Description</label>
                            <textarea name="meta_description" rows="4"
                                class="w-full bg-white border border-gray-100 rounded-2xl px-6 py-4 text-sm font-bold text-gray-900 focus:ring-4 focus:ring-black/5 focus:border-black transition-all resize-none outline-none"
                                placeholder="Enter SEO description..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Side Controls --}}
            <div class="space-y-10">
                {{-- Visibility Card --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-10 shadow-[0_8px_40px_rgba(0,0,0,0.03)]">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Visibility</h3>
                    </div>

                    <div class="space-y-6">
                        <label class="relative flex items-start gap-4 p-5 rounded-[2rem] border-2 border-gray-100/50 hover:border-emerald-500/20 cursor-pointer transition-all group has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/30">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-200 mt-1 peer-checked:border-emerald-500 peer-checked:bg-white flex items-center justify-center transition-all bg-white relative">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black uppercase tracking-widest text-gray-900 transition-colors">Active Status</span>
                                <span class="block text-[10px] font-bold text-gray-400 mt-1 group-hover:text-gray-500 transition-colors">Visibility control for customers</span>
                            </div>
                        </label>

                        <label class="relative flex items-start gap-4 p-5 rounded-[2rem] border-2 border-gray-100/50 hover:border-violet-500/20 cursor-pointer transition-all group has-[:checked]:border-violet-500 has-[:checked]:bg-violet-50/30">
                            <input type="checkbox" name="is_home" id="is_home" value="1" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-200 mt-1 peer-checked:border-violet-500 peer-checked:bg-white flex items-center justify-center transition-all bg-white relative">
                                <div class="w-2.5 h-2.5 rounded-full bg-violet-500 scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black uppercase tracking-widest text-gray-900 transition-colors">Set as Home Page</span>
                                <span class="block text-[10px] font-bold text-gray-400 mt-1 group-hover:text-gray-500 transition-colors">Use as storefront homepage</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Layout Settings --}}
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-10 shadow-[0_8px_40px_rgba(0,0,0,0.03)]">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                        <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">Layout Settings</h3>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Container Width</label>
                        <div class="relative">
                            <select name="layout" class="w-full bg-gray-50 border-none rounded-2xl px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-900 focus:ring-4 focus:ring-black/5 transition-all appearance-none cursor-pointer">
                                <option value="default">Global Default Setting</option>
                                <option value="contained">Contained Focus</option>
                                <option value="fluid">Fluid (Edge-to-Edge)</option>
                            </select>
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="group w-full h-16 rounded-2xl bg-violet-600 text-white font-black text-[10px] uppercase tracking-[0.3em] shadow-2xl shadow-violet-500/20 hover:bg-black hover:shadow-black/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-4">
                    Create Page
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('title').addEventListener('input', function () {
        let slug = this.value.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endpush
@endsection