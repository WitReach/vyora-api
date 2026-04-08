@extends('layouts.admin')

@section('header', 'Promotion Manager')

@section('content')
<div class="space-y-8 pb-24">
    <!-- Hero Header -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-indigo-600 font-bold text-xs uppercase tracking-widest mb-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                Revenue Optimization
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Campaign Coupons</h1>
            <p class="text-gray-500 font-medium max-w-lg">Design high-converting discounts, flash sales, and auto-apply magic coupons to drive consumer action.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.online-store.coupons.create') }}" class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-gray-800 transition-all shadow-xl shadow-black/10 active:scale-95">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                New Campaign
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex items-center gap-3 animate-in fade-in slide-in-from-top-2">
        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
        </div>
        <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        @if($coupons->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Coupon Identity</th>
                        <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Logic & Value</th>
                        <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-center">Performance</th>
                        <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-5 text-[11px] font-black text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($coupons as $coupon)
                    <tr class="group hover:bg-gray-50/50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs shrink-0 border border-indigo-100/50">
                                    {{ substr($coupon->code, 0, 2) }}
                                </div>
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <span class="text-base font-black text-gray-900 tracking-tight group-hover:text-indigo-600 transition-colors">{{ $coupon->code }}</span>
                                        @if($coupon->is_default_magic)
                                        <span class="bg-amber-100 text-amber-700 p-1 rounded-md shadow-sm" title="Magic Auto-Apply">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2L12.39 6.84L17.73 7.62L13.86 11.39L14.77 16.71L10 14.21L5.23 16.71L6.14 11.39L2.27 7.62L7.61 6.84L10 2Z" /></svg>
                                        </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-400 font-semibold truncate max-w-[180px]">{{ $coupon->name ?: 'Standard Promotion' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-black uppercase tracking-wide border border-emerald-100">
                                    @if($coupon->type === 'percentage')
                                        {{ (float)$coupon->discount_amount }}% OFF
                                    @elseif($coupon->type === 'fixed')
                                        ₹{{ number_format($coupon->discount_amount, 2) }} OFF
                                    @elseif($coupon->type === 'free_shipping')
                                        Free Ship
                                    @else
                                        BOGO {{ $coupon->bogo_buy_qty }}+{{ $coupon->bogo_get_qty }}
                                    @endif
                                </div>
                                @if($coupon->min_cart_value)
                                <p class="text-[10px] text-gray-400 font-bold px-1 uppercase tracking-tighter">Min: ₹{{ number_format($coupon->min_cart_value, 0) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="space-y-1">
                                <div class="text-sm font-black text-gray-900">{{ number_format($coupon->times_used) }}</div>
                                <div class="w-20 mx-auto bg-gray-100 rounded-full h-1 overflow-hidden">
                                    @if($coupon->usage_limit)
                                        <div class="bg-indigo-500 h-full" style="width: {{ ($coupon->times_used / $coupon->usage_limit) * 100 }}%"></div>
                                    @else
                                        <div class="bg-gray-300 h-full w-full"></div>
                                    @endif
                                </div>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $coupon->usage_limit ? '/ ' . $coupon->usage_limit : 'Limitless' }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $isExpired = $coupon->expires_at && $coupon->expires_at->isPast();
                                $isFuture = $coupon->starts_at && $coupon->starts_at->isFuture();
                                
                                if (!$coupon->is_active) {
                                    $statusColor = 'bg-gray-100 text-gray-500 border-gray-200';
                                    $statusLabel = 'Paused';
                                } elseif ($isExpired) {
                                    $statusColor = 'bg-rose-50 text-rose-600 border-rose-100';
                                    $statusLabel = 'Expired';
                                } elseif ($isFuture) {
                                    $statusColor = 'bg-amber-50 text-amber-600 border-amber-100';
                                    $statusLabel = 'Scheduled';
                                } else {
                                    $statusColor = 'bg-emerald-500 text-white border-transparent shadow-md shadow-emerald-100';
                                    $statusLabel = 'Live';
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.online-store.coupons.edit', $coupon->id) }}" 
                                    class="p-2.5 rounded-xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all" title="Edit Properties">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('admin.online-store.coupons.destroy', $coupon->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Archive this campaign?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2.5 rounded-xl text-gray-400 hover:text-rose-600 hover:bg-rose-50 transition-all" title="Archive Coupon">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-50">
            {{ $coupons->links() }}
        </div>
        @endif
        @else
        <div class="p-20 text-center">
            <div class="w-24 h-24 bg-gray-50 rounded-[2.5rem] flex items-center justify-center text-gray-300 mx-auto mb-6 border border-gray-100 shadow-sm">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">No Active Campaigns</h3>
            <p class="text-gray-500 font-medium mb-8 max-w-xs mx-auto text-sm">Your promotional inventory is empty. Start your first revenue drive with a custom coupon code.</p>
            <a href="{{ route('admin.online-store.coupons.create') }}" class="inline-flex items-center gap-2 bg-black text-white px-8 py-3.5 rounded-2xl font-bold text-sm hover:bg-gray-800 transition-all shadow-xl active:scale-95">
                + Initiate First Campaign
            </a>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes slideInFromTop {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideInFromTop 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection
