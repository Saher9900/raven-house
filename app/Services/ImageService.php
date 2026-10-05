<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class ImageService
{
    public function storeImage(UploadedFile $file, string $directory = 'products'): string
    {
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs("images/{$directory}", $file, $filename);

        if ($path === false) {
            throw new RuntimeException('Failed to store uploaded image on the public disk.');
        }

        return '/storage/'.$path;
    }

    public function deleteImage(string $imagePath): void
    {
        // Don't delete default images from the folder
        $defaultImages = [
            '/storage/images/default-product.png',
            '/storage/images/default-category.png',
        ];

        if (in_array($imagePath, $defaultImages)) {
            return;
        }

        if (str_starts_with($imagePath, '/storage/')) {
            $path = str_replace('/storage/', '', $imagePath);
            Storage::disk('public')->delete($path);
        }
    }

    public function getDefaultImage(string $type = 'product'): string
    {
        return $type === 'category' ? '/storage/images/default-category.png' : '/storage/images/default-product.png';
    }
}
