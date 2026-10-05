<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SunglassesCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;

class SunglassesCategoryController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $categories = SunglassesCategory::all();

        return view('admin.sunglasses-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.sunglasses-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = SunglassesCategory::create(['name' => $validated['name']]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $this->imageService->storeImage($request->file('image'), 'categories');
            $category->update(['image' => $imagePath]);
        } else {
            // Use default image if none provided
            $category->update(['image' => $this->imageService->getDefaultImage('category')]);
        }

        return redirect()->route('admin.sunglasses-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(SunglassesCategory $sunglassesCategory)
    {
        return view('admin.sunglasses-categories.edit', compact('sunglassesCategory'));
    }

    public function update(Request $request, SunglassesCategory $sunglassesCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $sunglassesCategory->update(['name' => $validated['name']]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if it's not a default
            if ($sunglassesCategory->image && $sunglassesCategory->image !== $this->imageService->getDefaultImage('category')) {
                $this->imageService->deleteImage($sunglassesCategory->image);
            }

            $imagePath = $this->imageService->storeImage($request->file('image'), 'categories');
            $sunglassesCategory->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.sunglasses-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(SunglassesCategory $sunglassesCategory)
    {
        // Delete image if it's not a default
        if ($sunglassesCategory->image && $sunglassesCategory->image !== $this->imageService->getDefaultImage('category')) {
            $this->imageService->deleteImage($sunglassesCategory->image);
        }

        $sunglassesCategory->delete();

        return redirect()->route('admin.sunglasses-categories.index')->with('success', 'Category deleted successfully.');
    }
}

