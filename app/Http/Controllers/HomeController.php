<?php

namespace App\Http\Controllers;

use App\Models\FeaturedProduct;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = FeaturedProduct::query()
            ->with(['perfume.images', 'sunglasses.images'])
            ->orderBy('position')
            ->orderBy('id')
            ->get();

        return view('website.pages.index', compact('featuredProducts'));
    }
}
