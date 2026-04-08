@extends('layouts.admin')

@section('header', 'Create Coupon')

@section('content')
<div class="pb-24">
    <form action="{{ route('admin.online-store.coupons.store') }}" method="POST" id="couponForm">
        @csrf
        
        <!-- Sticky Header for Actions -->
        <div class="sticky top-0 z-40 bg-gray-50/80 backdrop-blur-md border-b border-gray-200 -mx-4 px-4 py-4 mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.online-store.coupons.index') }}" class="p-2 hover:bg-white rounded-xl transition-colors group">
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">New Campaign Coupon</h1>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Campaign & Discounts</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.online-store.coupons.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900">Discard</a>
                <button type="submit" class="inline-flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-800 transition-all shadow-lg shadow-black/10 active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    Publish Coupon
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
                                <div class="relative group/input">
                                    <input type="text" name="code" id="code" required 
                                        class="block w-full bg-gray-50 border-0 rounded-2xl py-4 px-5 text-lg font-mono font-bold tracking-widest text-indigo-600 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all uppercase placeholder:text-gray-300" 
                                        placeholder="E.G. FLASH50">
                                    <button type="button" onclick="generateCode()" 
                                        class="absolute right-3 top-3 p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all group/btn">
                                        <svg class="w-4 h-4 transition-transform group-hover/btn:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                    </button>
                                </div>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-tighter px-1">Customers enter this code at checkout to trigger the discount.</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold text-gray-700 ml-1">Internal Campaign Name</label>
                                <input type="text" name="name" id="name" 
                                    class="block w-full bg-gray-50 border-0 rounded-2xl py-4 px-5 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all placeholder:text-gray-400" 
                                    placeholder="e.g. Black Friday 2026 - Main">
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-tighter px-1">Only visible to administrators in reportings.</p>
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
                                        <option value="percentage">Percentage Discount (%)</option>
                                        <option value="fixed">Fixed Amount (₹)</option>
                                        <option value="free_shipping">Free Shipping Reward</option>
                                        <option value="bogo">Buy X Get Y (BOGO)</option>
                                    </select>
                                </div>

                                <div id="discount_value_block" class="space-y-2">
                                    <label for="discount_amount" class="text-xs font-bold uppercase tracking-widest text-gray-500 ml-1">Discount Amount</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="discount_amount" id="discount_amount" 
                                            class="block w-full bg-white border-gray-200 rounded-xl py-3 px-4 text-gray-900 font-bold focus:ring-2 focus:ring-emerald-500 transition-all shadow-sm" 
                                            placeholder="20.00">
                                        <div id="type_indicator" class="absolute right-4 top-3 text-gray-400 font-bold">%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- BOGO Advanced Panel -->
                            <div id="bogo_panel" class="hidden animate-in fade-in slide-in-from-top-4">
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
                                                <input type="number" name="bogo_buy_qty" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 3">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold opacity-80 uppercase tracking-tighter">Reward Amount (Y)</label>
                                                <input type="number" name="bogo_get_qty" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 1">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-bold opacity-80 uppercase tracking-tighter text-indigo-100">Reward Max Value Cap</label>
                                                <input type="number" step="0.01" name="bogo_max_discount" class="w-full bg-white/10 border-0 rounded-xl py-3 px-4 text-white font-bold placeholder:text-white/30 focus:ring-2 focus:ring-white/50" placeholder="e.g. 500">
                                            </div>
                                        </div>
                                        <div class="mt-6 flex items-start gap-3 bg-black/20 p-4 rounded-2xl">
                                            <svg class="w-5 h-5 text-indigo-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <p class="text-xs text-indigo-100 leading-relaxed font-medium">BOGO Engine automatically picks the cheapest items in the cart to make "free" up to your reward amount. The max value cap ensures expensive items only get discounted up to your chosen limit.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Criteria & Stacking -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:border-gray-200 transition-colors">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900">Eligibility & Stacking Rules</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Minimum Requirements -->
                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Cart Constraints</h3>
                                <div class="space-y-4">
                                    <div class="group/field">
                                        <label class="text-sm font-bold text-gray-700 ml-1 block mb-1.5 transition-colors group-hover/field:text-indigo-600">Minimum Spend (₹)</label>
                                        <input type="number" step="0.01" name="min_cart_value" 
                                            class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-semibold" 
                                            placeholder="e.g. 1500.00">
                                    </div>
                                    <div class="group/field">
                                        <label class="text-sm font-bold text-gray-700 ml-1 block mb-1.5 transition-colors group-hover/field:text-indigo-600">Minimum Unit Quantity</label>
                                        <input type="number" name="min_item_quantity" 
                                            class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-semibold" 
                                            placeholder="e.g. 2 items">
                                    </div>
                                </div>
                            </div>

                            <!-- Stacking Toggles -->
                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Business Logic Protections</h3>
                                <div class="space-y-3">
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="exclude_sale_items" id="exclude_sale_items" value="1" 
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="exclude_sale_items" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">Exclude Sale Items</span>
                                            <span class="block text-[11px] font-medium text-gray-400 leading-tight">Blocks used on already discounted stock.</span>
                                        </label>
                                    </div>
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="first_time_users_only" id="first_time_users_only" value="1" 
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="first_time_users_only" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">First Order Only</span>
                                            <span class="block text-[11px] font-medium text-gray-400 leading-tight">Valid for users with 0 order history.</span>
                                        </label>
                                    </div>
                                    <div class="relative flex items-start p-4 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors cursor-pointer group/toggle">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="can_combine" id="can_combine" value="1" 
                                                class="h-5 w-5 rounded bg-gray-200 border-0 text-black focus:ring-black">
                                        </div>
                                        <label for="can_combine" class="ml-3 cursor-pointer">
                                            <span class="block text-sm font-bold text-gray-900 group-hover/toggle:text-indigo-600 transition-colors">Allow Stacking</span>
                                            <span class="block text-[11px] font-medium text-gray-400 leading-tight">Can be used with other active codes.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Target Selection -->
                        <div class="mt-12 space-y-6 pt-10 border-t border-gray-50">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">Inventory Filtering (Scope)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Target Products (ID List)</label>
                                    <input type="text" name="applicable_product_ids" 
                                        class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 placeholder:text-gray-400" 
                                        placeholder="Comma separated IDs e.g. 102, 205">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter px-1">Whole store if left blank.</p>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-gray-700 ml-1">Target Categories (ID List)</label>
                                    <input type="text" name="applicable_category_ids" 
                                        class="block w-full border-gray-100 bg-gray-50 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-indigo-500 placeholder:text-gray-400" 
                                        placeholder="Comma separated IDs e.g. 5, 22">
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
                                <p class="text-[11px] text-indigo-300 font-medium">Immediately usable?</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                <div class="w-12 h-7 bg-indigo-800 rounded-full peer peer-focus:ring-0 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>

                        <div class="bg-black/20 rounded-2xl p-5 border border-white/10 space-y-4">
                            <div class="relative flex items-start group/magic">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="is_default_magic" id="is_default_magic" value="1" 
                                        class="h-5 w-5 rounded bg-indigo-950 border-0 text-white focus:ring-0 focus:ring-offset-0">
                                </div>
                                <label for="is_default_magic" class="ml-3 cursor-pointer">
                                    <span class="block text-sm font-bold text-white group-hover/magic:text-emerald-400 transition-colors">Magic Auto-Apply</span>
                                    <p class="text-[10px] text-indigo-200 leading-tight mt-0.5">Applied automatically if cart matches rules. No code required by user.</p>
                                </label>
                            </div>
                        </div>

                        <div class="relative flex items-start group/show">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="show_on_product_page" id="show_on_product_page" value="1" 
                                    class="h-5 w-5 rounded bg-indigo-950 border-0 text-white focus:ring-0 focus:ring-offset-0">
                            </div>
                            <label for="show_on_product_page" class="ml-3 cursor-pointer">
                                <span class="block text-sm font-bold text-white group-hover/show:text-emerald-400 transition-colors">Public Display</span>
                                <p class="text-[10px] text-indigo-200 leading-tight mt-0.5">Show "Best price ₹X with coupon" on Product Cards.</p>
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
                            <input type="number" name="usage_limit" 
                                class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black focus:bg-white transition-all font-bold" 
                                placeholder="e.g. 500">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-black text-gray-500 uppercase tracking-tighter">Usage Limit Per User</label>
                            <input type="number" name="usage_limit_per_user" 
                                class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black focus:bg-white transition-all font-bold" 
                                placeholder="1">
                        </div>

                        <div class="pt-4 space-y-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-black text-gray-500 uppercase tracking-tighter">Launch Window (START)</label>
                                <input type="datetime-local" name="starts_at" 
                                    class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-black focus:bg-white transition-all text-xs font-bold">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-black text-gray-500 uppercase tracking-tighter text-red-500">Expiry Deadline (END)</label>
                                <input type="datetime-local" name="expires_at" 
                                    class="w-full bg-red-50 border-0 rounded-2xl py-3 px-4 focus:ring-2 focus:ring-red-500 focus:bg-white transition-all text-xs font-bold text-red-600">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function generateCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        const pref = ['DEAL', 'SAVE', 'GET', 'OFF', 'CODE', 'VIP'];
        const randomPref = pref[Math.floor(Math.random() * pref.length)];
        
        for (let i = 0; i < 4; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('code').value = randomPref + result;
        
        // Trigger visual feedback
        const input = document.getElementById('code');
        input.classList.add('ring-2', 'ring-indigo-500', 'bg-white');
        setTimeout(() => {
            input.classList.remove('ring-2', 'ring-indigo-500', 'bg-white');
        }, 800);
    }

    function handleTypeChange() {
        const type = document.getElementById('type').value;
        const discountBlock = document.getElementById('discount_value_block');
        const indicator = document.getElementById('type_indicator');
        const bogoPanel = document.getElementById('bogo_panel');

        // Logic based on types
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

    // Initialize UI on load
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
