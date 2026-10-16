<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Perfume;
use App\Models\Sunglasses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * @var array<string, class-string<Perfume|Sunglasses>>
     */
    private array $allowedProducts = [
        'perfume' => Perfume::class,
        'sunglasses' => Sunglasses::class,
    ];

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->cartPayload($request));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_type' => ['required', 'string', 'in:perfume,sunglasses'],
            'product_id' => ['required', 'integer', 'min:1'],
            'quantity' => ['sometimes', 'integer', 'min:1', 'max:99'],
        ]);

        $product = $this->resolveProduct($validated['product_type'], (int) $validated['product_id']);

        if ($product->stock < 1) {
            return response()->json(['message' => 'This product is out of stock.'], 422);
        }

        $quantity = min((int) ($validated['quantity'] ?? 1), $product->stock);

        if (Auth::check()) {
            $cartItem = CartItem::query()->firstOrNew([
                'user_id' => Auth::id(),
                'productable_type' => $product::class,
                'productable_id' => $product->id,
            ]);

            $cartItem->fill([
                'quantity' => $cartItem->exists
                    ? min($cartItem->quantity + $quantity, $product->stock)
                    : $quantity,
                'unit_price' => $product->effectivePrice(),
            ])->save();
        } else {
            $guestCart = $request->session()->get('guest_cart', []);
            $key = $this->guestCartKey($validated['product_type'], $product->id);
            $guestCart[$key] = [
                'product_type' => $validated['product_type'],
                'product_id' => $product->id,
                'quantity' => min(($guestCart[$key]['quantity'] ?? 0) + $quantity, $product->stock),
            ];
            $request->session()->put('guest_cart', $guestCart);
        }

        return response()->json([
            'message' => 'Product added to cart.',
            ...$this->cartPayload($request),
        ]);
    }

    public function update(Request $request, string $cartItem): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        if (Auth::check()) {
            $item = CartItem::query()->findOrFail($cartItem);
            $this->authorizeCartItem($item);
            $product = $item->productable;

            if (! $product || $product->stock < 1) {
                $item->delete();

                return response()->json([
                    'message' => 'This product is no longer available.',
                    ...$this->cartPayload($request),
                ], 422);
            }

            $item->update([
                'quantity' => min($validated['quantity'], $product->stock),
                'unit_price' => $product->effectivePrice(),
            ]);
        } else {
            $key = $this->guestCartKeyFromId($cartItem);
            $guestCart = $request->session()->get('guest_cart', []);
            abort_unless(isset($guestCart[$key]), 404);

            $entry = $guestCart[$key];
            $product = $this->findProduct($entry['product_type'], (int) $entry['product_id']);

            if (! $product || $product->stock < 1) {
                unset($guestCart[$key]);
                $request->session()->put('guest_cart', $guestCart);

                return response()->json([
                    'message' => 'This product is no longer available.',
                    ...$this->cartPayload($request),
                ], 422);
            }

            $guestCart[$key]['quantity'] = min($validated['quantity'], $product->stock);
            $request->session()->put('guest_cart', $guestCart);
        }

        return response()->json([
            'message' => 'Cart updated.',
            ...$this->cartPayload($request),
        ]);
    }

    public function destroy(Request $request, string $cartItem): JsonResponse
    {
        if (Auth::check()) {
            $item = CartItem::query()->findOrFail($cartItem);
            $this->authorizeCartItem($item);
            $item->delete();
        } else {
            $key = $this->guestCartKeyFromId($cartItem);
            $guestCart = $request->session()->get('guest_cart', []);
            abort_unless(isset($guestCart[$key]), 404);
            unset($guestCart[$key]);
            $request->session()->put('guest_cart', $guestCart);
        }

        return response()->json([
            'message' => 'Item removed from cart.',
            ...$this->cartPayload($request),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function cartPayload(Request $request): array
    {
        if (Auth::check()) {
            $this->mergeGuestCart($request);

            $items = CartItem::query()
                ->with(['productable.images'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();

            $mappedItems = $items->map(function (CartItem $item): ?array {
                $product = $item->productable;

                if (! $product) {
                    $item->delete();

                    return null;
                }

                return $this->mapProductToCartItem(
                    (string) $item->id,
                    $product,
                    $item->quantity,
                    (float) $item->unit_price,
                );
            })->filter()->values();
        } else {
            $guestCart = $request->session()->get('guest_cart', []);
            $mappedItems = collect($guestCart)->map(function (array $entry, string $key) use (&$guestCart): ?array {
                $product = $this->findProduct($entry['product_type'], (int) $entry['product_id']);

                if (! $product || $product->stock < 1) {
                    unset($guestCart[$key]);

                    return null;
                }

                $quantity = min((int) $entry['quantity'], $product->stock);
                $guestCart[$key]['quantity'] = $quantity;

                return $this->mapProductToCartItem(
                    $this->guestCartItemId($entry['product_type'], (int) $entry['product_id']),
                    $product,
                    $quantity,
                    $product->effectivePrice(),
                );
            })->filter()->values();

            $request->session()->put('guest_cart', $guestCart);
        }

        $total = $mappedItems->sum('subtotal');

        return [
            'items' => $mappedItems,
            'count' => $mappedItems->sum('quantity'),
            'total' => round($total, 2),
        ];
    }

    private function mergeGuestCart(Request $request): void
    {
        $guestCart = $request->session()->get('guest_cart', []);

        foreach ($guestCart as $entry) {
            $product = $this->findProduct($entry['product_type'], (int) $entry['product_id']);

            if (! $product || $product->stock < 1) {
                continue;
            }

            $item = CartItem::query()->firstOrNew([
                'user_id' => Auth::id(),
                'productable_type' => $product::class,
                'productable_id' => $product->id,
            ]);

            $item->quantity = $item->exists
                ? min($item->quantity + (int) $entry['quantity'], $product->stock)
                : min((int) $entry['quantity'], $product->stock);

            if (! $item->exists) {
                $item->unit_price = $product->effectivePrice();
            }

            $item->save();
        }

        $request->session()->forget('guest_cart');
    }

    /**
     * @return array<string, mixed>
     */
    private function mapProductToCartItem(string $id, Perfume|Sunglasses $product, int $quantity, float $unitPrice): array
    {
        return [
            'id' => $id,
            'product_type' => $product->productTypeLabel(),
            'product_id' => $product->id,
            'name' => $product->name,
            'brand' => $product->brand,
            'image' => $product->images->first()
                ? asset($product->images->first()->image_path)
                : null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => round($unitPrice * $quantity, 2),
        ];
    }

    private function resolveProduct(string $type, int $id): Perfume|Sunglasses
    {
        return $this->allowedProducts[$type]::query()->findOrFail($id);
    }

    private function findProduct(string $type, int $id): Perfume|Sunglasses|null
    {
        $modelClass = $this->allowedProducts[$type] ?? null;

        return $modelClass ? $modelClass::query()->with('images')->find($id) : null;
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== Auth::id(), 403);
    }

    private function guestCartKey(string $type, int $productId): string
    {
        return "{$type}:{$productId}";
    }

    private function guestCartItemId(string $type, int $productId): string
    {
        return "{$type}-{$productId}";
    }

    private function guestCartKeyFromId(string $id): string
    {
        $parts = explode('-', $id);
        abort_unless(count($parts) === 2 && ctype_digit($parts[1]), 404);

        return $this->guestCartKey($parts[0], (int) $parts[1]);
    }
}
