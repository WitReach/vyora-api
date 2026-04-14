@extends('layouts.admin')

@section('header', 'Edit Page')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h1 class="text-xl font-bold">Page Settings: {{ $mnpage->title }}</h1>
            <a href="{{ route('admin.online-store.mnpages.index') }}" class="text-sm text-gray-500 hover:text-black font-medium">Cancel</a>
        </div>

        <form action="{{ route('admin.online-store.mnpages.update', $mnpage) }}" method="POST" class="p-6 space-y-8">
            @csrf @method('PUT')
            
            <input type="hidden" name="content" value="{{ json_encode($mnpage->content) }}">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Info -->
                <div class="space-y-6">
                    <h3 class="font-bold text-gray-900 border-b pb-2">Identification</h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Page Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $mnpage->title) }}" required class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">URL Slug</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $mnpage->slug) }}" required class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-black focus:border-black">
                    </div>

                    <h3 class="font-bold text-gray-900 border-b pb-2 pt-4">Search Optimization (SEO)</h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $mnpage->meta_title) }}" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-black focus:border-black">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="4" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-black focus:border-black">{{ old('meta_description', $mnpage->meta_description) }}</textarea>
                    </div>
                </div>

                <!-- Settings -->
                <div class="space-y-6">
                    <h3 class="font-bold text-gray-900 border-b pb-2">Status & Layout</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $mnpage->is_active) ? 'checked' : '' }} class="h-4 w-4 border-gray-300 rounded text-black focus:ring-black">
                            <span class="text-sm font-bold text-gray-900">Active Stage (Visible)</span>
                        </label>

                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 cursor-pointer">
                            <input type="hidden" name="is_home" value="0">
                            <input type="checkbox" name="is_home" value="1" {{ old('is_home', $mnpage->is_home) ? 'checked' : '' }} class="h-4 w-4 border-gray-300 rounded text-black focus:ring-black">
                            <span class="text-sm font-bold text-gray-900">Primary Home Page</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Display Mode</label>
                        <select name="layout" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-black focus:border-black">
                            <option value="default" {{ $mnpage->layout === 'default' ? 'selected' : '' }}>System Default</option>
                            <option value="contained" {{ $mnpage->layout === 'contained' ? 'selected' : '' }}>Contained</option>
                            <option value="fluid" {{ $mnpage->layout === 'fluid' ? 'selected' : '' }}>Edge-to-Edge (Fluid)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button type="submit" class="bg-black text-white px-8 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-800 transition-colors">
                    Update Page
                </button>
            </div>
        </form>
    </div>
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