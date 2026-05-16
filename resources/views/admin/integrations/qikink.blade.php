@extends('layouts.admin')
@section('header', 'Qikink Integration')

@section('content')
<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.online-store.integrations.index') }}" class="hover:text-gray-700 transition-colors">Integrations</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-700 font-semibold">Qikink</span>
    </div>

    {{-- Header Card --}}
    <div class="bg-[#111827] rounded-2xl p-8 flex items-center gap-6 overflow-hidden relative">
        <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-white/5"></div>
        <div class="absolute -right-4 bottom-0 w-32 h-32 rounded-full bg-[#10b981]/10"></div>
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center shrink-0 relative z-10">
            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="relative z-10">
            <h1 class="text-2xl font-black text-white tracking-tight">Qikink</h1>
            <p class="text-emerald-300 text-sm mt-1">Automated Print on Demand and Dropshipping fulfillment</p>
            <div class="flex items-center gap-3 mt-3">
                <span id="statusBadge" class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full {{ $saved['enabled'] ? 'bg-green-500/20 text-green-300' : 'bg-white/10 text-white/40' }}">
                    {{ $saved['enabled'] ? '● Active' : '○ Inactive' }}
                </span>
                <span class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full {{ $saved['mode'] === 'live' ? 'bg-green-500/20 text-green-300' : 'bg-amber-500/20 text-amber-300' }}">
                    {{ $saved['mode'] === 'live' ? '🟢 Live Mode' : '🧪 Test Mode' }}
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-semibold">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.online-store.integrations.update', 'qikink') }}" method="POST" id="qikinkForm">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Config --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Enable & Mode --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-5">
                    <h2 class="text-xs font-black uppercase tracking-widest text-gray-400">Gateway Settings</h2>

                    {{-- Enable Toggle --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Enable Qikink API</p>
                            <p class="text-xs text-gray-400 mt-0.5">Automatically process orders for Qikink-enabled products</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="enabled" id="enabledToggle" class="sr-only peer" {{ $saved['enabled'] ? 'checked' : '' }}>
                            <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-checked:bg-black after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6"></div>
                        </label>
                    </div>

                    {{-- Mode Toggle --}}
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Mode</p>
                        <div class="flex gap-2">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="mode" value="test" class="sr-only peer" {{ $saved['mode'] !== 'live' ? 'checked' : '' }}>
                                <div class="border-2 rounded-xl px-4 py-3 transition-all peer-checked:border-amber-400 peer-checked:bg-amber-50 border-gray-200 text-center">
                                    <p class="text-sm font-black text-gray-800">🧪 Test Mode</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Use sandbox environment</p>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="mode" value="live" class="sr-only peer" {{ $saved['mode'] === 'live' ? 'checked' : '' }}>
                                <div class="border-2 rounded-xl px-4 py-3 transition-all peer-checked:border-green-400 peer-checked:bg-green-50 border-gray-200 text-center">
                                    <p class="text-sm font-black text-gray-800">🟢 Live Mode</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Real fulfillment enabled</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- API Credentials --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-6 space-y-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-black uppercase tracking-widest text-gray-400">API Credentials</h2>
                        <a href="https://dashboard.qikink.com/integration/api" target="_blank"
                            class="text-[11px] font-bold text-emerald-600 hover:underline flex items-center gap-1">
                            Get from Dashboard
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>

                    {{-- Client ID --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5">Client ID</label>
                        <div class="relative">
                            <input type="text" name="client_id" id="clientId" value="{{ $saved['client_id'] }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono text-gray-900 focus:outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition-all"
                                placeholder="Your Client ID" required>
                        </div>
                    </div>

                    {{-- Client Secret --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-widest mb-1.5">Client Secret</label>
                        <div class="relative">
                            <input type="password" name="client_secret" id="clientSecret" value="{{ $saved['client_secret'] }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono text-gray-900 focus:outline-none focus:border-gray-900 focus:ring-1 focus:ring-gray-900 transition-all pr-12"
                                placeholder="••••••••••••••••••••" required>
                            <button type="button" onclick="toggleSecret()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-gray-400 mt-1">Stored encrypted in the database. Leave unchanged to keep existing secret.</p>
                    </div>

                    {{-- Test Connection Button --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="button" onclick="testConnection()"
                            id="testBtn"
                            class="flex items-center gap-2 px-5 py-2.5 border border-gray-300 text-sm font-bold rounded-xl hover:bg-gray-50 hover:border-gray-900 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Test Connection
                        </button>
                        <div id="testResult" class="text-sm font-semibold hidden"></div>
                    </div>
                </div>

                {{-- Save --}}
                <div class="flex items-center gap-3">
                    <button type="submit" class="px-8 py-3 bg-black text-white text-sm font-black rounded-xl hover:bg-gray-800 transition-all shadow-lg shadow-gray-200">
                        Save Configuration
                    </button>
                    <a href="{{ route('admin.online-store.integrations.index') }}" class="px-5 py-3 border border-gray-200 text-sm font-bold rounded-xl text-gray-600 hover:bg-gray-50 transition-all">
                        Cancel
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                {{-- How it Works --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5">
                    <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">How it works</h3>
                    <ol class="space-y-3">
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-gray-900 text-white text-[10px] font-black flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <span class="text-xs text-gray-600 leading-relaxed">
                                Get <a href="https://dashboard.qikink.com/integration/api" target="_blank" class="font-bold text-emerald-600 hover:underline">API keys</a> from Qikink Dashboard
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-gray-900 text-white text-[10px] font-black flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <span class="text-xs text-gray-600 leading-relaxed">
                                Enable the integration here and insert the API keys. Test connection.
                            </span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-5 h-5 rounded-full bg-gray-900 text-white text-[10px] font-black flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <span class="text-xs text-gray-600 leading-relaxed">
                                Enable Qikink on the edit page of products you wish to fulfill.
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleSecret() {
    const input = document.getElementById('clientSecret');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}

async function testConnection() {
    const btn    = document.getElementById('testBtn');
    const result = document.getElementById('testResult');
    btn.disabled = true;
    btn.innerHTML = `<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Testing...`;
    result.className = 'text-sm font-semibold hidden';

    try {
        const res  = await fetch('{{ route('admin.online-store.integrations.qikink.test') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });
        const data = await res.json();
        result.className = `text-sm font-semibold flex items-center gap-2 ${data.success ? 'text-green-600' : 'text-red-600'}`;
        result.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.success ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'}"/></svg> ${data.message}`;
    } catch (e) {
        result.className = 'text-sm font-semibold text-red-600 flex items-center gap-2';
        result.innerHTML = '✗ Network error. Please try again.';
    }

    btn.disabled = false;
    btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Test Connection`;
}
</script>
@endpush
@endsection
