<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Perfume;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function destroy(Image $image)
    {
        $imagePath = $image->getRawOriginal('image_path');
        $product = $image->imageable;

        $this->imageService->deleteImage($imagePath);

        $image->delete();

        // Determine the route based on product type
        if ($product instanceof Perfume) {
            $routeName = 'admin.perfumes.edit';
        } else {
            $routeName = 'admin.sunglasses.edit';
        }

        // Return JSON for AJAX requests, redirect for regular form submissions
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route($routeName, $product),
            ]);
        }

        return redirect()->route($routeName, $product)->with('success', 'Image deleted successfully.');
    }
}
