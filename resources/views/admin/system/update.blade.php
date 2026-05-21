@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-6xl mx-auto pb-16">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">System Updates</h1>
            <p class="text-sm text-gray-500 mt-2 max-w-2xl">Manage Over-The-Air (OTA) updates for both the Admin Backend and User Frontend. Keep your system secure and up-to-date with the latest open-source releases.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-bold">Success</h4>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start gap-3">
            <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-bold">Error</h4>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- ── MAINTENANCE MODE CARD ───────────────────────────── --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl {{ $maintenanceMode ? 'bg-amber-100 text-amber-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center">
                        @if($maintenanceMode)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Maintenance Mode</h2>
                        <div class="flex items-center gap-2 mt-1 text-sm">
                            Status: 
                            @if($maintenanceMode)
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-xs uppercase tracking-wide animate-pulse">Active</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-800 font-bold text-xs uppercase tracking-wide">Live</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <p class="text-sm text-gray-600 leading-relaxed mb-4">
                    Before installing updates, it is highly recommended to place your store into Maintenance Mode. This prevents customers from placing orders or encountering errors while the system files are being overwritten and the database is being migrated.
                </p>
                
                @if($maintenanceMode)
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 text-xs p-3 rounded-lg mb-4">
                        <strong>Note:</strong> You can bypass the maintenance screen by appending <code>?vyora-update</code> to the URL.
                    </div>
                @endif
            </div>

            <form action="{{ route('admin.settings.update.maintenance') }}" method="POST">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white {{ $maintenanceMode ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-amber-500 hover:bg-amber-600' }} transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    {{ $maintenanceMode ? 'Disable Maintenance Mode (Go Live)' : 'Enable Maintenance Mode' }}
                </button>
            </form>
        </div>

        {{-- ── SUPPORT VYORA CARD ───────────────────────────── --}}
        <div class="bg-gradient-to-br from-indigo-50 to-white rounded-2xl shadow-sm border border-indigo-100 p-6 flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Support Vyora</h2>
                <p class="text-sm text-gray-600 leading-relaxed mb-2">
                    Vyora is open-source and free to use. If you find this software valuable for your business, please consider supporting its continuous development.
                </p>
            </div>
            
            <div class="mt-4 pt-4 border-t border-indigo-50">
                <a href="https://pages.razorpay.com/support-vyora" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Support Project
                </a>
                <div class="mt-3 flex items-center justify-center space-x-1.5 text-[10px] text-gray-500 uppercase tracking-wide">
                    <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 21a11.955 11.955 0 01-9.618-7.016m19.236 0a11.955 11.955 0 00-19.236 0M12 11V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Secured by Razorpay</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── UPDATE PANELS ───────────────────────────── --}}
    <h2 class="text-xl font-bold text-gray-900 mb-4 tracking-tight">Available Updates</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Frontend Update Panel -->
        <div class="bg-white rounded-2xl shadow-sm border {{ isset($frontUpdateAvailable) && $frontUpdateAvailable ? 'border-blue-300' : 'border-gray-200' }} overflow-hidden flex flex-col">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-none mb-1">User Frontend</h3>
                        <p class="text-xs text-gray-500 font-mono">WitReach/vyora-frontend</p>
                    </div>
                </div>
                <div class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 shadow-sm">v{{ $frontendCurrent }}</div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
                @php
                    $frontLatest = $frontendRelease ? $frontendRelease['version'] : null;
                    $frontUpdateAvailable = $frontLatest && version_compare($frontLatest, $frontendCurrent, '>');
                @endphp

                @if($frontUpdateAvailable)
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4 bg-blue-50 border border-blue-100 p-3 rounded-lg">
                            <span class="flex h-3 w-3 relative">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                            </span>
                            <h3 class="text-sm font-bold text-blue-700">New Version v{{ $frontLatest }} Available!</h3>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 max-h-48 overflow-y-auto custom-scrollbar text-sm text-gray-700 whitespace-pre-wrap">{{ $frontendRelease['notes'] }}</div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        @if($frontendRelease['download_url'])
                            <form action="{{ route('admin.settings.update.process') }}" method="POST" onsubmit="return confirm('Update frontend? This will overwrite frontend files and restart the Next.js app.');">
                                @csrf
                                <input type="hidden" name="type" value="frontend">
                                <input type="hidden" name="download_url" value="{{ $frontendRelease['download_url'] }}">
                                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-xl font-bold shadow-sm hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Install Frontend Update
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-amber-50 text-amber-800 rounded-xl text-sm border border-amber-200">
                                <strong>Asset Missing:</strong> No valid zip asset was attached to this release on GitHub.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">Up to date</h4>
                        <p class="text-sm text-gray-500">The frontend is running the latest stable version.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Backend Update Panel -->
        <div class="bg-white rounded-2xl shadow-sm border {{ isset($backUpdateAvailable) && $backUpdateAvailable ? 'border-blue-300' : 'border-gray-200' }} overflow-hidden flex flex-col">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-none mb-1">Admin Backend</h3>
                        <p class="text-xs text-gray-500 font-mono">WitReach/vyora-api</p>
                    </div>
                </div>
                <div class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 shadow-sm">v{{ $backendCurrent }}</div>
            </div>
            
            <div class="p-6 flex-1 flex flex-col">
                @php
                    $backLatest = $backendRelease ? $backendRelease['version'] : null;
                    $backUpdateAvailable = $backLatest && version_compare($backLatest, $backendCurrent, '>');
                @endphp

                @if($backUpdateAvailable)
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-4 bg-blue-50 border border-blue-100 p-3 rounded-lg">
                            <span class="flex h-3 w-3 relative">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-600"></span>
                            </span>
                            <h3 class="text-sm font-bold text-blue-700">New Version v{{ $backLatest }} Available!</h3>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6 max-h-48 overflow-y-auto custom-scrollbar text-sm text-gray-700 whitespace-pre-wrap">{{ $backendRelease['notes'] }}</div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-auto">
                        @if($backendRelease['download_url'])
                            <form action="{{ route('admin.settings.update.process') }}" method="POST" onsubmit="return confirm('Update Backend? This will run database migrations.');">
                                @csrf
                                <input type="hidden" name="type" value="backend">
                                <input type="hidden" name="download_url" value="{{ $backendRelease['download_url'] }}">
                                <button type="submit" class="w-full bg-slate-900 text-white px-4 py-3 rounded-xl font-bold shadow-sm hover:bg-slate-800 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Install Backend Update
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-amber-50 text-amber-800 rounded-xl text-sm border border-amber-200">
                                <strong>Asset Missing:</strong> No valid zip asset was attached to this release on GitHub.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-center py-8">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900 mb-1">Up to date</h4>
                        <p class="text-sm text-gray-500">The backend is running the latest stable version.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
    
    <div class="mt-12 text-center">
        <a href="{{ route('admin.settings.update.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-black bg-white border border-gray-200 px-6 py-2.5 rounded-full shadow-sm hover:shadow-md transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Refresh GitHub Check
        </a>
    </div>
</div>
@endsection
