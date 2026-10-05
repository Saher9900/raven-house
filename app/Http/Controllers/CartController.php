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
     * @var array<class-string, class-string>
     */
    private array $allowedProducts = [
        'perfume' => Perfume::class,
        'sunglasses' => Sunglasses::class,
    ];

    public function index(): JsonResponse
    {
        return response()->json($this->cartPayload());
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

        $cartItem = CartItem::query()->firstOrNew([
            'user_id' => Auth::id(),
            'productable_type' => $product::class,
            'productable_id' => $product->id,
        ]);

        $newQuantity = $cartItem->exists
            ? min($cartItem->quantity + $quantity, $product->stock)
            : $quantity;

        $cartItem->fill([
            'quantity' => $newQuantity,
            'unit_price' => $product->effectivePrice(),
        ])->save();

        return response()->json([
            'message' => 'Product added to cart.',
            ...$this->cartPayload(),
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeCartItem($cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = $cartItem->productable;

        if (! $product) {
            $cartItem->delete();

            return response()->json([
                'message' => 'This product is no longer available.',
                ...$this->cartPayload(),
            ]);
        }

        if ($product->stock < 1) {
            $cartItem->delete();

            return response()->json([
                'message' => 'This product is out of stock and was removed from your cart.',
                ...$this->cartPayload(),
            ], 422);
        }

        $cartItem->update([
            'quantity' => min($validated['quantity'], $product->stock),
            'unit_price' => $product->effectivePrice(),
        ]);

        return response()->json([
            'message' => 'Cart updated.',
            ...$this->cartPayload(),
        ]);
    }

    public function destroy(CartItem $cartItem): JsonResponse
    {
        $this->authorizeCartItem($cartItem);

        $cartItem->delete();

        return response()->json([
            'message' => 'Item removed from cart.',
            ...$this->cartPayload(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function cartPayload(): array
    {
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

            return [
                'id' => $item->id,
                'product_type' => $product->productTypeLabel(),
                'product_id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'image' => $product->images->first()
                    ? asset($product->images->first()->image_path)
                    : null,
                'quantity' => $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'subtotal' => round((float) $item->unit_price * $item->quantity, 2),
                'stock' => $product->stock,
            ];
        })->filter()->values();

        $total = $mappedItems->sum('subtotal');

        return [
            'items' => $mappedItems,
            'count' => $mappedItems->sum('quantity'),
            'total' => round($total, 2),
        ];
    }

    private function resolveProduct(string $type, int $id): Perfume|Sunglasses
    {
        $modelClass = $this->allowedProducts[$type];

        return $modelClass::query()->findOrFail($id);
    }

    private function authorizeCartItem(CartItem $cartItem): void
    {
        abort_if($cartItem->user_id !== Auth::id(), 403);
    }
}
