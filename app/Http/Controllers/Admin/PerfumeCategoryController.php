<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerfumesCategory;
use App\Services\ImageService;
use Illuminate\Http\Request;

class PerfumeCategoryController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $categories = PerfumesCategory::all();

        return view('admin.perfume-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.perfume-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $category = PerfumesCategory::create(['name' => $validated['name']]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $this->imageService->storeImage($request->file('image'), 'categories');
            $category->update(['image' => $imagePath]);
        } else {
            // Use default image if none provided
            $category->update(['image' => $this->imageService->getDefaultImage('category')]);
        }

        return redirect()->route('admin.perfume-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(PerfumesCategory $perfumeCategory)
    {
        return view('admin.perfume-categories.edit', compact('perfumeCategory'));
    }

    public function update(Request $request, PerfumesCategory $perfumeCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $perfumeCategory->update(['name' => $validated['name']]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Delete old image if it's not a default
            if ($perfumeCategory->image && $perfumeCategory->image !== $this->imageService->getDefaultImage('category')) {
                $this->imageService->deleteImage($perfumeCategory->image);
            }

            $imagePath = $this->imageService->storeImage($request->file('image'), 'categories');
            $perfumeCategory->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.perfume-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(PerfumesCategory $perfumeCategory)
    {
        // Delete image if it's not a default
        if ($perfumeCategory->image && $perfumeCategory->image !== $this->imageService->getDefaultImage('category')) {
            $this->imageService->deleteImage($perfumeCategory->image);
        }

        $perfumeCategory->delete();

        return redirect()->route('admin.perfume-categories.index')->with('success', 'Category deleted successfully.');
    }
}

