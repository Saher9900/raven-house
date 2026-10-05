<?php

namespace App\Http\Controllers;

use App\Models\Sunglasses;
use App\Models\SunglassesCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SunglassesController extends Controller
{
    public function index(Request $request): View
    {
        $query = Sunglasses::with(['category', 'images']);

        if ($request->filled('category')) {
            $query->where('sunglasses_category_id', $request->integer('category'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->string('name').'%');
        }

        match ($request->string('sort')->toString()) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $sunglasses = $query->paginate(12)->withQueryString();
        $categories = SunglassesCategory::orderBy('name')->get();

        return view('website.pages.sunglasses', compact('sunglasses', 'categories'));
    }

    public function show(Sunglasses $sunglasses)
    {
        $sunglasses->load(['category', 'images']);
        
        // Get related products from the same category (excluding current product)
        $relatedProducts = Sunglasses::where('sunglasses_category_id', $sunglasses->sunglasses_category_id)
            ->where('id', '!=', $sunglasses->id)
            ->with(['category', 'images'])
            ->limit(6)
            ->get();
        
        return view('website.pages.sunglasses.show', compact('sunglasses', 'relatedProducts'));
    }
}
