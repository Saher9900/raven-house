<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(): JsonResponse
    {
        $user = Auth::user();

        if (! $user->shipping_address) {
            return response()->json([
                'message' => 'Shipping address is required to complete checkout.',
                'requires_address' => true,
            ], 422);
        }

        $cartItems = CartItem::query()
            ->with('productable')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->productable;

            if (! $product) {
                return response()->json(['message' => 'One or more products in your cart are no longer available.'], 422);
            }

            if ($product->stock < $cartItem->quantity) {
                return response()->json([
                    'message' => "{$product->name} only has {$product->stock} left in stock.",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            $total = 0;
            $orderItemsData = [];

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->productable;
                $subtotal = round((float) $cartItem->unit_price * $cartItem->quantity, 2);
                $total += $subtotal;

                $orderItemsData[] = [
                    'productable_type' => $product::class,
                    'productable_id' => $product->id,
                    'product_name' => $product->name,
                    'product_brand' => $product->brand,
                    'product_type' => $product->productTypeLabel(),
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $cartItem->quantity);
            }

            $order = Order::query()->create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => round($total, 2),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone_number,
                'shipping_address' => $user->shipping_address,
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            CartItem::query()->where('user_id', $user->id)->delete();

            return $order->load('items');
        });

        return response()->json([
            'message' => 'Order placed successfully! Our team will review it shortly.',
            'order_id' => $order->id,
            'items' => [],
            'count' => 0,
            'total' => 0,
        ]);
    }
}
