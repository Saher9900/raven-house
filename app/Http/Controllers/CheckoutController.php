<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\Sunglasses;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function saveDelivery(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user) {
            $validated = $request->validate([
                'shipping_address' => ['required', 'string', 'max:1000'],
            ]);

            session(['checkout.details' => [
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone_number,
                'shipping_address' => $validated['shipping_address'],
            ]]);
        } else {
            $validated = $request->validate([
                'customer_name' => ['required', 'string', 'max:255'],
                'customer_phone' => ['required', 'string', 'max:20'],
                'shipping_address' => ['required', 'string', 'max:1000'],
            ]);

            session(['checkout.details' => $validated + ['customer_email' => null]]);
        }

        return response()->json(['redirect' => route('checkout.payment')]);
    }

    public function showPayment(): View|RedirectResponse
    {
        if (! session('checkout.details')) {
            return redirect()
                ->route('cart.index')
                ->with('error', __('website.checkout.requires_delivery'));
        }

        return view('website.pages.checkout-payment');
    }

    public function savePayment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['required', Rule::in(['cod'])],
        ]);

        session(['checkout.payment_method' => $validated['payment_method']]);

        return redirect()->route('checkout.review');
    }

    public function showReview(Request $request): View|RedirectResponse
    {
        $cartItems = $this->resolveCartItems(Auth::user(), $request);

        if ($cartItems->isEmpty() || $cartItems->contains(null)) {
            return redirect()
                ->route('cart.index')
                ->with('error', __('website.checkout.cart_empty'));
        }

        return view('website.pages.checkout-review', [
            'cartItems' => $cartItems,
            'total' => $this->calculateTotal($cartItems),
            'paymentMethod' => session('checkout.payment_method', 'cod'),
            'details' => session('checkout.details', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', Rule::in(['cod'])],
        ]);

        $cartItems = $this->resolveCartItems($user, $request);

        if ($cartItems->isEmpty() || $cartItems->contains(null)) {
            return redirect()
                ->route('cart.index')
                ->with('error', __('website.checkout.cart_empty'));
        }

        foreach ($cartItems as $cartItem) {
            $product = $cartItem['productable'];

            if ($product->stock < $cartItem['quantity']) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', __('website.checkout.insufficient_stock', [
                        'name' => $product->name,
                        'stock' => $product->stock,
                    ]));
            }
        }

        DB::transaction(function () use ($user, $validated, $cartItems, $request) {
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
                    'product_type' => $this->orderProductTypeLabel($product),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $quantity);
            }

            $order = Order::query()->create([
                'user_id' => $user?->id,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'total' => round($total, 2),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            if ($user) {
                CartItem::query()->where('user_id', $user->id)->delete();
            } else {
                $request->session()->forget('guest_cart');
            }
        });

        session()->forget('checkout');

        return redirect()
            ->route('perfumes.page')
            ->with('success', __('website.checkout.order_placed'));
    }

    private function resolveCartItems(?User $user, Request $request): Collection
    {
        if ($user) {
            return CartItem::query()
                ->with('productable')
                ->where('user_id', $user->id)
                ->get()
                ->map(fn (CartItem $item): array => [
                    'productable' => $item->productable,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                ]);
        }

        $productTypes = [
            'perfume' => Perfume::class,
            'sunglasses' => Sunglasses::class,
        ];

        return collect($request->session()->get('guest_cart', []))
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
    }

    private function calculateTotal(Collection $cartItems): float
    {
        return round(
            $cartItems->sum(
                fn (array $item): float => round((float) $item['unit_price'] * $item['quantity'], 2)
            ),
            2,
        );
    }

    private function orderProductTypeLabel(Perfume|Sunglasses $product): string
    {
        if ($product instanceof Perfume) {
            return 'Perfume'.match ($product->perfume_type) {
                'box' => ' - Box',
                'fragrance' => ' - Fragrances',
                default => '',
            };
        }

        return $product->productTypeLabel();
    }
}
