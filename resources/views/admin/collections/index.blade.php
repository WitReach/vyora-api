@extends('layouts.admin')

@section('header', 'Collections')

@section('content')
<div class="w-full pb-24">
    {{-- Top Action Bar --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 px-1">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tighter uppercase">All Collections</h1>
        </div>
        
        <div class="flex items-center gap-4">
             <a href="{{ route('admin.collections.create') }}" class="bg-black text-white px-8 py-3.5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs shadow-2xl hover:shadow-violet-500/20 hover:-translate-y-1 active:translate-y-0 transition-all">
                Add Collection
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition-all hover:shadow-md h-32 flex flex-col justify-center">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Total Collections</p>
            <h4 class="text-3xl font-black text-gray-900 leading-none">{{ $stats['total'] }}</h4>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm transition-all hover:shadow-md h-32 flex flex-col justify-center">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2">Active Storefront</p>
            <h4 class="text-3xl font-black text-green-600 leading-none">{{ $stats['active'] }}</h4>
        </div>
    </div>

    {{-- Collections List --}}
    <div class="bg-white shadow-[0_8px_30px_rgb(0,0,0,0.02)] rounded-[2.5rem] border border-gray-100/50 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-black text-gray-900 uppercase tracking-widest flex items-center gap-3">
                 <div class="w-1.5 h-6 bg-violet-600 rounded-full"></div>
                 Management Console
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Identity & Details</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Slug</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Visibility</th>
                        <th class="px-8 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Configuration</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($collections as $collection)
                        <tr class="group hover:bg-gray-50/50 transition-all">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 font-black text-xs uppercase tracking-tighter shadow-sm border border-white">
                                        {{ substr($collection->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-gray-900 tracking-tight">{{ $collection->name }}</div>
                                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5 line-clamp-1 italic max-w-md">{{ $collection->description ?: 'No briefing provided.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-xl text-[10px] font-bold font-mono tracking-tighter">/{{ $collection->slug }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($collection->is_active)
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                        <span class="text-[10px] font-black text-green-600 uppercase tracking-widest italic">Live & Active</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 opacity-50">
                                        <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Offline</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0">
                                    <a href="{{ route('admin.collections.edit', $collection) }}" class="p-2.5 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-violet-600 hover:border-violet-100 hover:shadow-lg hover:shadow-violet-500/10 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.collections.destroy', $collection) }}" method="POST" class="inline" onsubmit="return confirm('Archive this collection?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-red-600 hover:border-red-100 hover:shadow-lg hover:shadow-red-500/10 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-3xl flex items-center justify-center text-gray-300 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest italic">No Collections Found in Registry.</p>
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