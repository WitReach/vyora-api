<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'order_uuid' => 'required|exists:orders,uuid'
        ]);

        $order = Order::where('uuid', $request->order_uuid)->firstOrFail();

        // Create Razorpay Order
        $orderData = [
            'receipt' => $order->order_number,
            'amount' => $order->total_amount * 100, // Amount in paise
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture
        ];

        $razorpayOrder = $this->api->order->create($orderData);

        return response()->json([
            'order_id' => $razorpayOrder['id'],
            'amount' => $orderData['amount'],
            'key' => env('RAZORPAY_KEY'),
            'name' => 'Dope Style', // Site title from config normally
            'description' => 'Order #' . $order->order_number,
            'prefill' => [
                'name' => $order->shippingAddress?->name,
                'email' => $order->shippingAddress?->email,
                'contact' => $order->shippingAddress?->phone,
            ]
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required',
            'order_uuid' => 'required|exists:orders,uuid'
        ]);

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $this->api->utility->verifyPaymentSignature($attributes);

            // If signature verified, update order
            $order = Order::where('uuid', $request->order_uuid)->firstOrFail();

            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing', // Move from pending to processing
                'transaction_id' => $request->razorpay_payment_id,
                'payment_method' => 'Razorpay'
            ]);

            return response()->json(['success' => true, 'message' => 'Payment verified successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed: ' . $e->getMessage()], 400);
        }
    }
}
