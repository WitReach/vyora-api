@extends('layouts.admin')
@section('header', 'Integrations')

@section('content')
<div class="space-y-8">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Integrations</h1>
        <p class="text-sm text-gray-400 mt-1">Connect your store to third-party payment, email, and accounting services.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($integrations as $slug => $data)
        @php
            $isActive = $data['status'] === 'active';
            $isSoon   = $data['status'] === 'soon';
            $isEnabled = $data['enabled'] ?? false;
            $mode      = $data['mode'] ?? 'test';
        @endphp

        @if($isActive)
        <a href="{{ route('admin.online-store.integrations.show', $slug) }}"
            class="group relative bg-white border border-gray-200 rounded-2xl p-6 hover:border-gray-900 hover:shadow-lg transition-all duration-200 block">
        @else
        <div class="group relative bg-white border border-gray-200 rounded-2xl p-6 opacity-60 cursor-not-allowed">
        @endif

            @if($isSoon)
            <div class="absolute top-4 right-4">
                <span class="text-[10px] font-black uppercase tracking-widest bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full">Coming Soon</span>
            </div>
            @endif

            @if($isActive && $isEnabled)
            <div class="absolute top-4 right-4">
                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full {{ $mode === 'live' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $mode === 'live' ? '● Live' : '● Test' }}
                </span>
            </div>
            @endif

            <div class="flex items-center gap-4 mb-4">
                {{-- Icon --}}
                @if($slug === 'razorpay')
                <div class="w-14 h-14 rounded-xl bg-[#072654] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-8 h-8" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 32L20 8l12 24H8z" fill="#3395FF" opacity=".9"/>
                        <path d="M14 24l6-12 6 12h-12z" fill="white" opacity=".5"/>
                    </svg>
                </div>
                @elseif($slug === 'smtp')
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                @else
                <div class="w-14 h-14 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                @endif

                <div>
                    <h3 class="font-bold text-gray-900 text-base">{{ $data['name'] }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $data['description'] }}</p>
                </div>
            </div>

            @if($isActive)
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <span class="text-xs font-semibold {{ $isEnabled ? 'text-green-600' : 'text-gray-400' }}">
                    {{ $isEnabled ? 'Connected' : 'Not configured' }}
                </span>
                <span class="text-xs font-bold text-gray-400 group-hover:text-gray-900 transition-colors flex items-center gap-1">
                    Configure
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </div>
            @endif

        @if($isActive)
        </a>
        @else
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
