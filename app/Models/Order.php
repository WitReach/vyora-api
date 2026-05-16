<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (!$order->uuid) {
                $order->uuid = (string) \Illuminate\Support\Str::uuid();
            }
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(\Illuminate\Support\Str::random(8));
            }
        });
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
