@extends('layouts.admin')

@section('header', 'System Hub')

@section('content')
    <div class="space-y-10">
        {{-- Hero Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="group relative bg-white p-6 rounded-3xl border border-gray-100 shadow-lg shadow-black/5 hover:translate-y-[-2px] transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-450 mb-1">Net Revenue</p>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tighter">₹{{ number_format($stats['revenue']) }}</h3>
                </div>
            </div>

            <div class="group relative bg-white p-6 rounded-3xl border border-gray-100 shadow-lg shadow-black/5 hover:translate-y-[-2px] transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-violet-500/5 rounded-full blur-2xl group-hover:bg-violet-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-violet-50 border border-violet-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-450 mb-1">Captured Orders</p>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tighter">{{ $stats['total_orders'] }}</h3>
                </div>
            </div>

            <div class="group relative bg-[#0A0A0B] p-6 rounded-3xl border border-white/5 shadow-xl shadow-black/20 hover:translate-y-[-2px] transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 mb-1">Awaiting Action</p>
                    <h3 class="text-2xl font-black text-white tracking-tighter">{{ $stats['pending_orders'] }}</h3>
                </div>
            </div>

            <div class="group relative bg-white p-6 rounded-3xl border border-gray-100 shadow-lg shadow-black/5 hover:translate-y-[-2px] transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform duration-500">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-450 mb-1">SKU Count</p>
                    <h3 class="text-2xl font-black text-gray-900 tracking-tighter">{{ $stats['total_products'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Main Interaction Zone --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- List Section --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-8 bg-black rounded-full"></div>
                        <h4 class="text-base font-black text-gray-900 uppercase tracking-tighter">Recent Logistics</h4>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="text-[9px] font-black uppercase tracking-widest text-violet-600 hover:tracking-[0.2em] transition-all duration-500">View All →</a>
                </div>

                <div class="bg-white rounded-[2rem] border border-gray-100 shadow shadow-black/5 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-8 py-5 text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">Order ID</th>
                                <th class="px-8 py-5 text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">Lifecycle</th>
                                <th class="px-8 py-5 text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">Total</th>
                                <th class="px-8 py-5 text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recent_orders as $order)
                                <tr class="group hover:bg-gray-50/25 transition-all duration-300">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black text-gray-900 uppercase italic">#{{ $order->order_number }}</span>
                                            <span class="text-[9px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter italic">Captured Unit</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest italic">{{ $order->created_at->format('M d, H:i') }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-[11px] font-black text-gray-900 tracking-tighter">₹{{ number_format($order->total_amount) }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[8px] font-black uppercase tracking-[0.1em] italic
                                            {{ $order->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                                            {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                                            {{ !in_array($order->status, ['pending', 'delivered']) ? 'bg-gray-50 lg:bg-violet-50 text-gray-500 lg:text-violet-600 border border-gray-100 lg:border-violet-100' : '' }}
                                        ">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            @if($recent_orders->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-8 py-14 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-3.93a2 2 0 01-1.66.9l-.82 1.31a2 2 0 00-1.66.9h-3.86a2 2 0 00-1.66-.9l-.82-1.31a2 2 0 01-1.66-.9H4"></path></svg>
                                            </div>
                                            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-300 italic">No Active Data Packets</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-6">
                <div class="flex items-center gap-3 px-4">
                    <div class="w-1.5 h-8 bg-violet-600 rounded-full"></div>
                    <h4 class="text-base font-black text-gray-900 uppercase tracking-tighter">Quick Actions</h4>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <a href="{{ route('admin.products.index') }}" class="group relative p-6 bg-white rounded-3xl border border-gray-100 shadow shadow-black/5 hover:bg-black transition-all duration-500 overflow-hidden">
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <h5 class="text-[11px] font-black text-gray-900 group-hover:text-white uppercase tracking-widest transition-colors italic">Inventory View</h5>
                                <p class="text-[9px] font-bold text-gray-400 group-hover:text-gray-500 uppercase tracking-wide transition-colors">Catalog Management</p>
                            </div>
                            <div class="w-8 h-8 bg-gray-50 group-hover:bg-white/10 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-all duration-500">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.online-store.mnpages.index') }}" class="group relative p-6 bg-white rounded-3xl border border-gray-100 shadow shadow-black/5 hover:bg-violet-600 transition-all duration-500 overflow-hidden">
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="space-y-0.5">
                                <h5 class="text-[11px] font-black text-gray-900 group-hover:text-white uppercase tracking-widest transition-colors italic">Page Design</h5>
                                <p class="text-[9px] font-bold text-gray-400 group-hover:text-violet-200 uppercase tracking-wide transition-colors">Interface Refinement</p>
                            </div>
                            <div class="w-8 h-8 bg-gray-50 group-hover:bg-white/10 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-all duration-500">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            </div>
                        </div>
                    </a>

                    <div class="p-6 bg-gray-50 rounded-3xl border border-gray-100 italic">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-1 h-5 bg-black rounded-full"></div>
                            <h6 class="text-[9px] font-black uppercase text-gray-900 tracking-widest">System Note</h6>
                        </div>
                        <p class="text-[9px] font-bold text-gray-400 uppercase leading-relaxed tracking-tighter">
                            Status cycles stable. Logistical units currently processing through core clearing houses for final validation.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection