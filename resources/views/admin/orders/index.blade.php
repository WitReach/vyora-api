@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-6">Orders</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b text-gray-500 text-sm">
                        <th class="py-3 px-4">Order #</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-mono text-sm">{{ $order->order_number }}</td>
                            <td class="py-3 px-4">{{ $order->created_at->format('M d, Y H:i') }}</td>
                            <td class="py-3 px-4">
                                {{ $order->shippingAddress?->name ?? 'Guest' }}<br>
                                <span class="text-xs text-gray-500">{{ $order->shippingAddress?->email }}</span>
                            </td>
                            <td class="py-3 px-4 font-bold">₹{{ number_format($order->total_amount) }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection