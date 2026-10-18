<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedProduct;
use App\Models\Perfume;
use App\Models\Sunglasses;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeaturedProductController extends Controller
{
    public function index(): View
    {
        $featuredProducts = FeaturedProduct::query()
            ->with(['perfume', 'sunglasses'])
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        $availablePerfumes = Perfume::query()
            ->whereDoesntHave('featuredProducts')
            ->orderBy('name')
            ->get();

        $availableSunglasses = Sunglasses::query()
            ->whereDoesntHave('featuredProducts')
            ->orderBy('name')
            ->get();

        return view('admin.featured-products.index', compact(
            'featuredProducts',
            'availablePerfumes',
            'availableSunglasses',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product' => ['required', 'string', 'regex:/^(perfume|sunglasses):[1-9][0-9]*$/'],
        ]);

        [$productType, $productId] = explode(':', $validated['product'], 2);

        $product = match ($productType) {
            'perfume' => Perfume::query()->find($productId),
            'sunglasses' => Sunglasses::query()->find($productId),
        };

        if ($product === null) {
            return back()->withErrors(['product' => 'The selected product is no longer available.'])->withInput();
        }

        $foreignKey = $productType === 'perfume' ? 'perfume_id' : 'sunglasses_id';

        if (FeaturedProduct::query()->where($foreignKey, $product->getKey())->exists()) {
            return back()->withErrors(['product' => 'This product is already featured.'])->withInput();
        }

        FeaturedProduct::query()->create([
            $foreignKey => $product->getKey(),
            'position' => ((int) FeaturedProduct::query()->max('position')) + 1,
        ]);

        return redirect()->route('admin.featured-products.index')
            ->with('success', 'Featured product added successfully.');
    }

    public function destroy(FeaturedProduct $featuredProduct): RedirectResponse
    {
        $featuredProduct->delete();

        return redirect()->route('admin.featured-products.index')
            ->with('success', 'Featured product removed successfully.');
    }

    public function move(Request $request, FeaturedProduct $featuredProduct): RedirectResponse
    {
        $validated = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ]);

        $moved = DB::transaction(function () use ($featuredProduct, $validated): bool {
            $featuredProducts = FeaturedProduct::query()
                ->orderBy('position')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $currentIndex = $featuredProducts->search(
                fn (FeaturedProduct $product): bool => $product->is($featuredProduct),
            );

            if ($currentIndex === false) {
                return false;
            }

            $targetIndex = $currentIndex + ($validated['direction'] === 'up' ? -1 : 1);

            if (! $featuredProducts->has($targetIndex)) {
                return false;
            }

            $featuredProducts->splice($currentIndex, 1, [$featuredProducts->get($targetIndex)]);
            $featuredProducts->splice($targetIndex, 1, [$featuredProduct]);

            foreach ($featuredProducts->values() as $index => $product) {
                $product->update(['position' => $index + 1]);
            }

            return true;
        });

        if (! $moved) {
            return back()->withErrors(['direction' => 'The featured product order could not be changed.']);
        }

        return redirect()->route('admin.featured-products.index')
            ->with('success', 'Featured product order updated successfully.');
    }
}
