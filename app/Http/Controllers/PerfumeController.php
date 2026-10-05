<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use App\Models\PerfumesCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfumeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Perfume::with(['category', 'images']);

        if ($request->filled('category')) {
            $query->where('perfumes_category_id', $request->integer('category'));
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->string('name').'%');
        }

        match ($request->string('sort')->toString()) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $perfumes = $query->paginate(12)->withQueryString();
        $categories = PerfumesCategory::orderBy('name')->get();

        return view('website.pages.perfumes', compact('perfumes', 'categories'));
    }

    public function show(Perfume $perfume)
    {
        $perfume->load(['category', 'images']);
        
        // Get related products from the same category (excluding current product)
        $relatedProducts = Perfume::where('perfumes_category_id', $perfume->perfumes_category_id)
            ->where('id', '!=', $perfume->id)
            ->with(['category', 'images'])
            ->limit(6)
            ->get();
        
        return view('website.pages.perfumes.show', compact('perfume', 'relatedProducts'));
    }
}
