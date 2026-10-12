<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\Sunglasses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user && ! $user->shipping_address) {
            return response()->json([
                'message' => 'Shipping address is required to complete checkout.',
                'requires_address' => true,
            ], 422);
        }

        $validated = $user ? [] : $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        if ($user) {
            $cartItems = CartItem::query()
                ->with('productable')
                ->where('user_id', $user->id)
                ->get()
                ->map(fn (CartItem $item): array => [
                    'productable' => $item->productable,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);
        } else {
            $productTypes = [
                'perfume' => Perfume::class,
                'sunglasses' => Sunglasses::class,
            ];

            $cartItems = collect($request->session()->get('guest_cart', []))
                ->map(function (array $entry) use ($productTypes): ?array {
                    $productClass = $productTypes[$entry['product_type']] ?? null;
                    $product = $productClass
                        ? $productClass::query()->find($entry['product_id'])
                        : null;

                    if (! $product) {
                        return null;
                    }

                    return [
                        'productable' => $product,
                        'quantity' => (int) $entry['quantity'],
                        'unit_price' => $product->effectivePrice(),
                    ];
                });

            if ($cartItems->contains(null)) {
                return response()->json([
                    'message' => 'One or more products in your cart are no longer available.',
                ], 422);
            }
        }

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        foreach ($cartItems as $cartItem) {
            $product = $cartItem['productable'];
            $quantity = $cartItem['quantity'];

            if (! $product) {
                return response()->json(['message' => 'One or more products in your cart are no longer available.'], 422);
            }

            if ($product->stock < $quantity) {
                return response()->json([
                    'message' => "{$product->name} only has {$product->stock} left in stock.",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($user, $validated, $cartItems, $request) {
            $total = 0;
            $orderItemsData = [];

            foreach ($cartItems as $cartItem) {
                $product = $cartItem['productable'];
                $quantity = $cartItem['quantity'];
                $unitPrice = $cartItem['unit_price'];
                $subtotal = round((float) $unitPrice * $quantity, 2);
                $total += $subtotal;

                $orderItemsData[] = [
                    'productable_type' => $product::class,
                    'productable_id' => $product->id,
                    'product_name' => $product->name,
                    'product_brand' => $product->brand,
                    'product_type' => $product->productTypeLabel(),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $quantity);
            }

            $order = Order::query()->create([
                'user_id' => $user?->id,
                'status' => 'pending',
                'total' => round($total, 2),
                'customer_name' => $user ? $user->name : $validated['customer_name'],
                'customer_email' => $user?->email,
                'customer_phone' => $user ? $user->phone_number : $validated['customer_phone'],
                'shipping_address' => $user ? $user->shipping_address : $validated['shipping_address'],
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            if ($user) {
                CartItem::query()->where('user_id', $user->id)->delete();
            } else {
                $request->session()->forget('guest_cart');
            }

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
