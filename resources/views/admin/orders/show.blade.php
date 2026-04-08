@extends('layouts.admin')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Order: {{ $order->order_number }}</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Orders</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Items -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-4">Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center border-b pb-4 last:border-0 last:pb-0">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                    @if($item->variant_name)
                                        <p class="text-sm text-gray-500">Variant: {{ $item->variant_name }}</p>
                                    @elseif($item->sku)
                                        <p class="text-sm text-gray-500">
                                            SKU: {{ $item->sku->code }}
                                            @foreach($item->sku->attributeValues as $av)
                                                | {{ $av->attribute->name }}: {{ $av->value }}
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ $item->quantity }} x ₹{{ number_format($item->price) }}
                                    </p>
                                    <p class="font-bold text-gray-900">₹{{ number_format($item->total) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t mt-4 pt-4 flex justify-between items-center font-bold text-lg">
                        <span>Total</span>
                        <span>₹{{ number_format($order->total_amount) }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Status</h3>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full border rounded-md p-2 mb-4" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </form>
                    <p class="text-xs text-gray-400">Changed will be saved immediately.</p>
                </div>

                <!-- Customer -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">Customer</h3>
                    @if($order->shippingAddress)
                        <p class="font-bold mb-1">{{ $order->shippingAddress->name }}</p>
                        <p class="text-sm mb-1"><a href="mailto:{{ $order->shippingAddress->email }}"
                                class="text-blue-600">{{ $order->shippingAddress->email }}</a></p>
                        <p class="text-sm mb-4 text-gray-600">{{ $order->shippingAddress->phone }}</p>

                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Shipping Address</h4>
                        <p class="text-sm text-gray-600">
                            {{ $order->shippingAddress->address_line1 }}<br>
                            @if($order->shippingAddress->address_line2) {{ $order->shippingAddress->address_line2 }}<br> @endif
                            {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} -
                            {{ $order->shippingAddress->zip_code }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500">No address details available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection