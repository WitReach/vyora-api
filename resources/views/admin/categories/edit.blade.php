@extends('layouts.admin')

@section('header', 'Edit Category')

@section('content')
    <div class="w-full pb-24">
        {{-- Top Action Bar --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Edit Category</h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 hover:bg-white transition-all">Cancel</a>
                <button type="submit" form="edit-category-form"
                    class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                    Update Category
                </button>
            </div>
        </div>

        <form id="edit-category-form" action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                {{-- Main Data --}}
                <div class="md:col-span-2 space-y-8">
                    <div
                        class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-10">
                        <h3
                            class="text-lg font-black text-gray-900 uppercase tracking-widest mb-10 flex items-center gap-3">
                            <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                            General Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Category
                                    Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                    placeholder="e.g. Streetwear"
                                    class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 px-5 text-gray-900 font-bold focus:ring-2 focus:ring-violet-500 transition-all text-lg tracking-tight">
                            </div>

                            <div>
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Slug</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-xs font-bold text-gray-400">/</span>
                                    </div>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                                        required placeholder="streetwear"
                                        class="block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 pl-8 pr-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all font-mono italic">
                                </div>
                            </div>

                            <div class="md:col-span-2 pt-4">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Parent
                                    Hierarchy</label>
                                <div class="relative">
                                    <select name="parent_id"
                                        class="appearance-none block w-full bg-gray-50/50 border-0 ring-1 ring-inset ring-gray-100 rounded-2xl py-4 h-14 px-5 text-sm font-bold text-gray-900 focus:ring-2 focus:ring-violet-500 transition-all cursor-pointer">
                                        <option value="">None (Root Category)</option>
                                        @foreach($categories as $cat)
                                            @if($cat->id != $category->id)
                                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2 pt-4">
                                <label
                                    class="block text-[10px] font-black uppercase tracking-[0.15em] text-gray-400 mb-2 ml-1">Visibility
                                    Status</label>
                                <label
                                    class="flex items-center cursor-pointer gap-4 p-4 bg-gray-50/50 rounded-2xl border border-gray-100 transition-all hover:bg-white group/status">
                                    <div class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-violet-600">
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-black uppercase tracking-widest text-gray-700 group-hover/status:text-gray-900">Show
                                            in Storefront</span>
                                        <span
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic">Active
                                            means show in store front, Inactive means dont show in store front</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Settings --}}
                <div class="space-y-6">
                    <div
                        class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 p-8">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-4 italic">Internal
                            Tracking</h4>
                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <span class="text-xs font-bold text-gray-500">Status</span>
                                <span
                                    class="text-[10px] font-black uppercase tracking-widest text-green-600 bg-green-50 px-2 py-1 rounded-lg">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection