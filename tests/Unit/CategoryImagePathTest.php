<?php

use App\Models\Image;
use App\Models\PerfumesCategory;
use App\Models\SunglassesCategory;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

it('normalizes perfume category image paths to the public storage URL', function () {
    $category = new PerfumesCategory(['image' => '/images/default-category.png']);

    expect($category->image)->toBe('/storage/images/default-category.png');
});

it('normalizes sunglasses category image paths to the public storage URL', function () {
    $category = new SunglassesCategory(['image' => '/images/default-category.png']);

    expect($category->image)->toBe('/storage/images/default-category.png');
});

it('resolves S3 object keys to public URLs for categories and product images', function () {
    $disk = Mockery::mock(FilesystemAdapter::class);
    $disk->shouldReceive('url')
        ->with('images/categories/category.jpg')
        ->andReturn('https://bucket.example.com/images/categories/category.jpg')
        ->twice();
    $disk->shouldReceive('url')
        ->with('images/perfumes/perfume.jpg')
        ->andReturn('https://bucket.example.com/images/perfumes/perfume.jpg');

    Storage::shouldReceive('disk')
        ->with('s3')
        ->andReturn($disk)
        ->times(3);

    $perfumeCategory = new PerfumesCategory(['image' => 'images/categories/category.jpg']);
    $sunglassesCategory = new SunglassesCategory(['image' => 'images/categories/category.jpg']);
    $productImage = new Image(['image_path' => 'images/perfumes/perfume.jpg']);

    expect($perfumeCategory->image)->toBe('https://bucket.example.com/images/categories/category.jpg')
        ->and($sunglassesCategory->image)->toBe('https://bucket.example.com/images/categories/category.jpg')
        ->and($productImage->image_path)->toBe('https://bucket.example.com/images/perfumes/perfume.jpg');
});
