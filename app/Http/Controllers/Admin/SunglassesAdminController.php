<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sunglasses;
use App\Models\SunglassesCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SunglassesAdminController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $sunglasses = Sunglasses::with('category')->paginate(20);

        return view('admin.sunglasses.index', compact('sunglasses'));
    }

    public function create()
    {
        $categories = SunglassesCategory::all();

        return view('admin.sunglasses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sunglasses_category_id' => 'required|exists:sunglasses_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sale' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $sunglasses = Sunglasses::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->imageService->storeImage($image, 'sunglasses');
                    $sunglasses->images()->create(['image_path' => $imagePath]);
                }
            }
        } else {
            // Store default image if no images uploaded
            $sunglasses->images()->create(['image_path' => $this->imageService->getDefaultImage('product')]);
        }

        return redirect()->route('admin.sunglasses.index')->with('success', 'Sunglasses created successfully.');
    }

    public function edit(Sunglasses $sunglasses)
    {
        $categories = SunglassesCategory::all();

        return view('admin.sunglasses.edit', compact('sunglasses', 'categories'));
    }

    public function update(Request $request, Sunglasses $sunglasses)
    {
        $validated = $request->validate([
            'sunglasses_category_id' => 'required|exists:sunglasses_categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sale' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'gender' => 'required|in:male,female',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $sunglasses->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imagePath = $this->imageService->storeImage($image, 'sunglasses');
                    $sunglasses->images()->create(['image_path' => $imagePath]);
                }
            }
        }

        return redirect()->route('admin.sunglasses.index')->with('success', 'Sunglasses updated successfully.');
    }

    public function destroy(Sunglasses $sunglasses)
    {
        // Delete all associated images
        foreach ($sunglasses->images as $image) {
            if ($image->image_path !== $this->imageService->getDefaultImage('product')) {
                $this->imageService->deleteImage($image->image_path);
            }
            $image->delete();
        }

        $sunglasses->delete();

        return redirect()->route('admin.sunglasses.index')->with('success', 'Sunglasses deleted successfully.');
    }
}
