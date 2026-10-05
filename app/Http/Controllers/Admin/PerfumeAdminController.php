<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perfume;
use App\Models\PerfumesCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;

class PerfumeAdminController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $perfumes = Perfume::with('category')->paginate(20);

        return view('admin.perfumes.index', compact('perfumes'));
    }

    public function create()
    {
        $categories = PerfumesCategory::all();

        return view('admin.perfumes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'perfumes_category_id' => 'required|exists:perfumes_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sale' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $perfume = Perfume::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->imageService->storeImage($image, 'perfumes');
                    $perfume->images()->create(['image_path' => $imagePath]);
                }
            }
        } else {
            // Store default image if no images uploaded
            $perfume->images()->create(['image_path' => $this->imageService->getDefaultImage('product')]);
        }

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume created successfully.');
    }

    public function edit(Perfume $perfume)
    {
        $categories = PerfumesCategory::all();

        return view('admin.perfumes.edit', compact('perfume', 'categories'));
    }

    public function update(Request $request, Perfume $perfume)
    {
        $validated = $request->validate([
            'perfumes_category_id' => 'required|exists:perfumes_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sale' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $perfume->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->imageService->storeImage($image, 'perfumes');
                    $perfume->images()->create(['image_path' => $imagePath]);
                }
            }
        }

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume updated successfully.');
    }

    public function destroy(Perfume $perfume)
    {
        // Delete all associated images
        foreach ($perfume->images as $image) {
            if ($image->image_path !== $this->imageService->getDefaultImage('product')) {
                $this->imageService->deleteImage($image->image_path);
            }
            $image->delete();
        }

        $perfume->delete();

        return redirect()->route('admin.perfumes.index')->with('success', 'Perfume deleted successfully.');
    }
}
