<?php

use App\Models\PerfumesCategory;
use App\Models\SunglassesCategory;

it('normalizes perfume category image paths to the public storage URL', function () {
    $category = new PerfumesCategory(['image' => '/images/default-category.png']);

    expect($category->image)->toBe('/storage/images/default-category.png');
});

it('normalizes sunglasses category image paths to the public storage URL', function () {
    $category = new SunglassesCategory(['image' => '/images/default-category.png']);

    expect($category->image)->toBe('/storage/images/default-category.png');
});
