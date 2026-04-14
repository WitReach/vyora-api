@extends('layouts.admin')

@section('header', 'Create Coupon')

@section('content')
<div class="max-w-5xl mx-auto pb-24">
    <form action="{{ route('admin.online-store.coupons.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div>
                <h1 class="text-xl font-bold">New Coupon Campaign</h1>
                <p class="text-sm text-gray-500">Define your discount rules and eligibility criteria.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.online-store.coupons.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-bold">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg text-sm font-bold hover:bg-gray-800">Create Coupon</button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold border-b pb-4 mb-6">Coupon Identification</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Coupon Code</label>
                            <div class="flex gap-2">
                                <input type="text" name="code" id="code" required class="flex-1 border border-gray-300 rounded px-3 py-2 text-sm font-mono uppercase focus:ring-black">
                                <button type="button" onclick="generateCode()" class="px-3 py-2 bg-gray-100 rounded text-xs font-bold">Auto</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Campaign Name</label>
                            <input type="text" name="name" class="w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="e.g. Winter Sale 2026">
                        </div>
                    </div>
                </div>

                <!-- Discount Logic -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold border-b pb-4 mb-6">Discount Rules</h3>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Type</label>
                                <select name="type" id="type" onchange="toggleType()" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="fixed">Fixed Amount (₹)</option>
                                    <option value="free_shipping">Free Shipping</option>
                                    <option value="bogo">Buy X Get Y (BOGO)</option>
                                </select>
                            </div>
                            <div id="val-wrap">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Value</label>
                                <input type="number" step="0.01" name="discount_amount" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                        </div>

                        <!-- BOGO Details -->
                        <div id="bogo-wrap" class="hidden p-4 bg-gray-50 rounded border border-gray-200 space-y-4">
                            <h4 class="text-xs font-bold uppercase text-gray-400">BOGO Configuration</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold uppercase mb-1">Buy Qty (X)</label>
                                    <input type="number" name="bogo_buy_qty" class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase mb-1">Get Qty (Y)</label>
                                    <input type="number" name="bogo_get_qty" class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold uppercase mb-1">Max Disc (₹)</label>
                                    <input type="number" step="0.01" name="bogo_max_discount" class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="font-bold border-b pb-4 mb-6">Eligibility & Restrictions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Min Spend (₹)</label>
                                <input type="number" step="0.01" name="min_cart_value" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Min Item Qty</label>
                                <input type="number" name="min_item_quantity" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="exclude_sale_items" value="1" class="h-4 w-4 rounded border-gray-300">
                                <span class="text-sm font-bold">Exclude Sale Items</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="first_time_users_only" value="1" class="h-4 w-4 rounded border-gray-300">
                                <span class="text-sm font-bold">New Customers Only</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="can_combine" value="1" class="h-4 w-4 rounded border-gray-300">
                                <span class="text-sm font-bold">Allow Stacking</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats & Limits -->
            <div class="space-y-8">
                <div class="bg-black rounded-lg shadow-lg p-6 text-white space-y-6">
                    <h3 class="font-bold border-b border-gray-800 pb-4 uppercase text-xs tracking-widest">Visibility</h3>
                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="font-bold text-sm">Status</span>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:bg-green-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_default_magic" value="1" class="h-4 w-4 rounded bg-gray-800 border-0">
                        <span class="text-xs font-bold">Auto-Apply (Magic)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="show_on_product_page" value="1" class="h-4 w-4 rounded bg-gray-800 border-0">
                        <span class="text-xs font-bold">Show on PDP</span>
                    </label>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                    <h3 class="font-bold border-b pb-4 uppercase text-xs tracking-widest text-gray-400">Usage Limits</h3>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Total Limit</label>
                        <input type="number" name="usage_limit" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Per User Limit</label>
                        <input type="number" name="usage_limit_per_user" value="1" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-bold">
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                    <h3 class="font-bold border-b pb-4 uppercase text-xs tracking-widest text-gray-400">Duration</h3>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Start Date</label>
                        <input type="datetime-local" name="starts_at" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">End Date</label>
                        <input type="datetime-local" name="expires_at" class="w-full border border-gray-300 rounded px-3 py-2 text-sm font-bold">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function generateCode() {
        const c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let r = ''; for (let i = 0; i < 8; i++) r += c.charAt(Math.floor(Math.random() * c.length));
        document.getElementById('code').value = r;
    }
    function toggleType() {
        const t = document.getElementById('type').value;
        const b = document.getElementById('bogo-wrap');
        const v = document.getElementById('val-wrap');
        b.classList.toggle('hidden', t !== 'bogo');
        v.classList.toggle('hidden', t === 'bogo' || t === 'free_shipping');
    }
</script>
@endsection
