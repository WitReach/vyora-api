<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest()
            ->select(['uuid', 'order_number', 'total_amount', 'status', 'created_at'])
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer.name' => 'required',
            'customer.email' => 'required|email',
            'customer.phone' => 'required',

            'address.line1' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.zip' => 'required',

            'items' => 'required|array',
            'items.*.sku_id' => 'required|exists:skus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 1. Create Address
                $addressData = $request->input('address');
                $customerData = $request->input('customer');

                $address = Address::create([
                    'user_id' => $request->user()?->id, // If authenticated
                    'name' => $customerData['name'],
                    'email' => $customerData['email'],
                    'phone' => $customerData['phone'],
                    'address_line1' => $addressData['line1'],
                    'address_line2' => $addressData['line2'] ?? null,
                    'city' => $addressData['city'],
                    'state' => $addressData['state'],
                    'zip_code' => $addressData['zip'],
                    'type' => 'shipping',
                ]);

                // 2. Calculate Total & Create Order
                $total = 0;
                $orderItemsData = [];

                foreach ($request->input('items') as $item) {
                    $sku = Sku::lockForUpdate()->find($item['sku_id']);

                    if ($sku->stock < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$sku->product->name} ({$sku->code})");
                    }

                    // Deduct Stock
                    $sku->decrement('stock', $item['quantity']);

                    $lineTotal = $sku->price * $item['quantity'];
                    $total += $lineTotal;

                    $orderItemsData[] = [
                        'sku' => $sku,
                        'qty' => $item['quantity'],
                        'price' => $sku->price,
                        'total' => $lineTotal
                    ];
                }

                $order = Order::create([
                    'user_id' => $request->user()?->id,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'total_amount' => $total,
                    'shipping_address_id' => $address->id,
                    'billing_address_id' => $address->id, // Same for now
                ]);

                // 3. Create Order Items
                foreach ($orderItemsData as $data) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $data['sku']->product_id,
                        'sku_id' => $data['sku']->id,
                        'product_name' => $data['sku']->product->name,
                        'variant_name' => '', // TODO: Generate variant name
                        'quantity' => $data['qty'],
                        'price' => $data['price'],
                        'total' => $data['total'],
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'order_uuid' => $order->uuid,
                    'message' => 'Order placed successfully!'
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
