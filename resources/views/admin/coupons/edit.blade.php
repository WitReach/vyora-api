@extends('layouts.admin')

@section('header', 'Edit Coupon')

@section('content')
<div class="pb-24">
    <form action="{{ route('admin.online-store.coupons.update', $coupon->id) }}" method="POST" id="couponForm">
        @csrf
        @method('PUT')
        
        <!-- Sticky Header for Actions -->
        <div class="sticky top-0 z-40 bg-gray-50/80 backdrop-blur-md border-b border-gray-200 -mx-4 px-4 py-4 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.online-store.coupons.index') }}" class="p-2 hover:bg-white rounded-xl transition-colors group">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Edit: {{ $coupon->code }}</h1>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Campaign & Discounts</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.online-store.coupons.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-800 transition-all shadow-lg shadow-black/10 active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    Update Coupon
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Configuration (Left & Middle) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Section 1: Identity -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:border-indigo-100 transition-colors">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Coupon Identity</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-2">
                            <div class="space-y-2">
                                <label for="code" class="text-sm font-bold text-gray-700 ml-1">Unique Redemption Code</label>
                                <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required 
                                    class="block w-full bg-gray-50 border-0 rounded-2xl py-4 px-5 text-lg font-mono font-bold tracking-widest text-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all uppercase placeholder:text-gray-300" 
                                    placeholder="E.G. FLASH50">
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-tighter px-1">Redemption code used by customers.</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold text-gray-700 ml-1">Internal Campaign Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $coupon->name) }}"
                                    class="block w-full bg-gray-50 border-0 rounded-2xl py-4 px-5 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all placeholder:text-gray-400" 
                                    placeholder="e.g. Black Friday 2026 - Main">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Discount Value -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:border-emerald-100 transition-colors">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Discount Logic</h2>
                        </div>

                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-widest text-gray-500 ml-1">Promotion Type</label>
                                    <select name="type" id="type" onchange="handleTypeChange()" 
                                        class="block w-full bg-white border-gray-200 rounded-xl py-3 px-4 text-gray-900 font-semibold focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm cursor-pointer">
                                        <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage Discount (%)</option>
                                        <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount (₹)</option>
                                        <option value="free_shipping" {{ $coupon->type == 'free_shipping' ? 'selected' : '' }}>Free Shipping Reward</option>
                                        <option value="bogo" {{ $coupon->type == 'bogo' ? 'selected' : '' }}>Buy X Get Y (BOGO)</option>
                                    </select>
                                </div>

                                <div id="discount_value_block" class="space-y-2 {{ in_array($coupon->type, ['free_shipping', 'bogo']) ? 'hidden' : '' }}">
                                    <label for="discount_amount" class="text-xs font-bold uppercase tracking-widest text-gray-500 ml-1">Discount Amount</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', $coupon->discount_amount) }}"
                                            class="block w-full bg-white border-gray-200 rounded-xl py-3 px-4 text-gray-900 font-bold focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm" 
                                            placeholder="20.00">
                                        <div id="type_indicator" class="absolute right-4 top-3 text-gray-400 font-bold">
                                            {{ $coupon->type == 'percentage' ? '%' : '₹' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BOGO Advanced Panel -->
                            <div id="bogo_panel" class="{{ $coupon->type == 'bogo' ? '' : 'hidden' }} animate-in fade-in slide-in-from-top-4">
                                <div class="bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden">
                                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                    <div class="relative z-10">
                                        <h3 class="text-base font-bold mb-6 flex items-center gap-2 uppercase tracking-widest">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                            Buy X Get Y Configuration
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold opacity-80 uppercase tracking-tighter">Required Purchase (X)</label>
                                                <input type="number" name="bogo_buy_qty" value="{{ old('bogo_buy_qty', $coupon->bogo_buy_qty) }}" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 3">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold opacity-80 uppercase tracking-tighter">Reward Amount (Y)</label>
                                                <input type="number" name="bogo_get_qty" value="{{ old('bogo_get_qty', $coupon->bogo_get_qty) }}" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 1">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold opacity-80 uppercase tracking-tighter text-indigo-100">Reward Max Value Cap</label>
                                                <input type="number" step="0.01" name="bogo_max_discount" value="{{ old('bogo_max_discount', $coupon->bogo_max_discount) }}" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Criteria -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:border-gray-200 transition-colors">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Eligibility & Stacking Rules</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Cart Constraints</h3>
                                <div class="space-y-4">
                                    <div class="group/field">
                                        <label class="text-sm font-bold text-gray-700 ml-1 block mb-1.5 transition-colors group-hover/field:text-indigo-600">Minimum Spend (₹)</label>
                                        <input type="number" step="0.01" name="min_cart_value" value="{{ old('min_cart_value', $coupon->min_cart_value) }}"
                                            class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-semibold">
                                    </div>
                                    <div class="group/field">
                                        <label class="text-sm font-bold text-gray-700 ml-1 block mb-1.5 transition-colors group-hover/field:text-indigo-600">Minimum Unit Quantity</label>
                                        <input type="number" name="min_item_quantity" value="{{ old('min_item_quantity', $coupon->min_item_quantity) }}"
                                            class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-semibold">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Restrictions</h3>
                                <div class="space-y-3">
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="exclude_sale_items" id="exclude_sale_items" value="1" {{ $coupon->exclude_sale_items ? 'checked' : '' }}
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="exclude_sale_items" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">Exclude Sale Items</span>
                                        </label>
                                    </div>
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="first_time_users_only" id="first_time_users_only" value="1" {{ $coupon->first_time_users_only ? 'checked' : '' }}
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="first_time_users_only" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">First Order Only</span>
                                        </label>
                                    </div>
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="can_combine" id="can_combine" value="1" {{ $coupon->can_combine ? 'checked' : '' }}
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="can_combine" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">Allow Stacking</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 space-y-6 pt-10 border-t border-gray-50">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Inventory Scope</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Target Products (ID List)</label>
                                    <input type="text" name="applicable_product_ids" value="{{ is_array($coupon->applicable_product_ids) ? implode(', ', $coupon->applicable_product_ids) : '' }}"
                                        class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Target Categories (ID List)</label>
                                    <input type="text" name="applicable_category_ids" value="{{ is_array($coupon->applicable_category_ids) ? implode(', ', $coupon->applicable_category_ids) : '' }}"
                                        class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Side Optimization Panel (Right) -->
            <div class="space-y-8">
                
                <!-- Status & Magic Section -->
                <div class="bg-indigo-900 rounded-3xl shadow-xl shadow-indigo-100 p-8 text-white">
                    <h2 class="text-base font-bold mb-8 uppercase tracking-widest border-b border-indigo-800 pb-4">Availability</h2>
                    <div class="space-y-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-bold">Campaign Status</h4>
                                <p class="text-[11px] text-indigo-300">Live redemption enabled</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-12 h-7 bg-indigo-800 rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>

                        <div class="bg-black/20 rounded-2xl p-5 border border-white/10 space-y-4">
                            <div class="relative flex items-start group/magic">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_default_magic" id="is_default_magic" value="1" {{ $coupon->is_default_magic ? 'checked' : '' }}
                                        class="h-5 w-5 rounded bg-indigo-950 border-0 text-white focus:ring-0 focus:ring-offset-0">
                                </div>
                                <label for="is_default_magic" class="ml-3 cursor-pointer">
                                    <span class="block text-sm font-bold text-white group-hover/magic:text-emerald-400 transition-colors">Magic Auto-Apply</span>
                                </label>
                            </div>
                        </div>

                        <div class="relative flex items-start group/show">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="show_on_product_page" id="show_on_product_page" value="1" {{ $coupon->show_on_product_page ? 'checked' : '' }}
                                    class="h-5 w-5 rounded bg-indigo-950 border-0 text-white focus:ring-0 focus:ring-offset-0">
                            </div>
                            <label for="show_on_product_page" class="ml-3 cursor-pointer">
                                <span class="block text-sm font-bold text-white group-hover/show:text-emerald-400 transition-colors">Public Display</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Limits & Duration -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-8">
                    <h2 class="text-sm font-black text-gray-400 mb-6 uppercase tracking-widest border-b border-gray-50 pb-4">Limits & Duration</h2>
                    
                    <div class="space-y-6">
                        <div class="space-y-1.5">
                            <label class="text-xs font-black text-gray-500 uppercase tracking-tighter">Total Redemption Limit</label>
                            <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black font-bold">
                            <p class="text-[10px] text-gray-400 font-bold px-1">Used so far: {{ $coupon->times_used }}</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-black text-gray-500 uppercase tracking-tighter">Usage Limit Per User</label>
                            <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}"
                                class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black font-bold">
                        </div>

                        <div class="pt-4 space-y-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-black text-gray-500 uppercase tracking-tighter">Start Date</label>
                                <input type="datetime-local" name="starts_at" value="{{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '' }}"
                                    class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black text-xs font-bold">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-black text-gray-500 uppercase tracking-tighter text-red-500">Expiry Deadline</label>
                                <input type="datetime-local" name="expires_at" value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}"
                                    class="w-full bg-red-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-red-500 text-xs font-bold text-red-600">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function handleTypeChange() {
        const type = document.getElementById('type').value;
        const discountBlock = document.getElementById('discount_value_block');
        const indicator = document.getElementById('type_indicator');
        const bogoPanel = document.getElementById('bogo_panel');

        if (type === 'percentage') {
            discountBlock.classList.remove('hidden');
            bogoPanel.classList.add('hidden');
            indicator.innerText = '%';
        } else if (type === 'fixed') {
            discountBlock.classList.remove('hidden');
            bogoPanel.classList.add('hidden');
            indicator.innerText = '₹';
        } else if (type === 'free_shipping') {
            discountBlock.classList.add('hidden');
            bogoPanel.classList.add('hidden');
        } else if (type === 'bogo') {
            discountBlock.classList.add('hidden');
            bogoPanel.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        handleTypeChange();
    });
</script>

<style>
    @keyframes slideInFromTop {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
        animation: slideInFromTop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection
