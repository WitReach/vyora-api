@extends('layouts.admin')

@section('header', 'Customise')

@section('content')
<div class="w-full pb-24">
    {{-- Header Section --}}
    <div class="mb-12 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-2 h-12 bg-black rounded-full shadow-[0_0_20px_rgba(0,0,0,0.1)]"></div>
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">Customise</h1>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-[0.2em] italic">Orchestrate your store experience</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.online-store.mnpages.create') }}"
                class="group relative inline-flex items-center gap-3 bg-black text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-900 transition-all shadow-2xl shadow-black/10 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-violet-600/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span class="relative z-10">Create New Page</span>
            </a>
        </div>
    </div>

    {{-- Content Table --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-[0_8px_40px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Title</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Slug</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/50">
                    @forelse($pages as $page)
                        <tr class="group hover:bg-gray-50/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-sm font-bold text-gray-400 group-hover:bg-black group-hover:text-white transition-all duration-500">
                                        {{ substr($page->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-tight">{{ $page->title }}</h4>
                                        @if($page->is_home)
                                            <div class="flex items-center gap-1.5 mt-1.5">
                                                <div class="w-1 h-1 rounded-full bg-violet-500"></div>
                                                <span class="text-[9px] font-black text-violet-600 uppercase tracking-widest">Home Page</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <code class="text-[10px] font-bold text-gray-400 bg-gray-50 px-2.5 py-1 rounded-lg">/{{ $page->slug }}</code>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @if($page->is_active)
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-widest border border-emerald-100/50">
                                        <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-50 text-red-500 text-[9px] font-black uppercase tracking-widest border border-red-100/50">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center justify-end gap-3 translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500">
                                    <a href="{{ route('admin.online-store.mnpages.design', $page) }}" target="_blank"
                                        class="h-10 px-6 inline-flex items-center bg-violet-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-violet-700 transition-colors shadow-lg shadow-violet-500/10">
                                        Design
                                    </a>
                                    <a href="{{ route('admin.online-store.mnpages.edit', $page) }}"
                                        class="h-10 w-10 inline-flex items-center justify-center bg-gray-50 text-gray-400 hover:text-black hover:bg-gray-100 rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @if(!$page->is_home)
                                        <form action="{{ route('admin.online-store.mnpages.destroy', $page) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="h-10 w-10 inline-flex items-center justify-center bg-red-50 text-red-400 hover:text-white hover:bg-red-500 rounded-xl transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h5 class="text-xs font-black text-gray-400 uppercase tracking-widest italic">No pages found. Create one to get started.</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection