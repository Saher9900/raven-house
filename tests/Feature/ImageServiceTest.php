<?php

use App\Services\ImageService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores uploaded images on the public disk and returns their public path', function () {
    Storage::fake('public');

    $imagePath = app(ImageService::class)->storeImage(
        UploadedFile::fake()->create('perfume.jpg', 100, 'image/jpeg'),
        'perfumes',
    );

    expect($imagePath)->toStartWith('/storage/images/perfumes/');
    expect(Storage::disk('public')->exists(substr($imagePath, strlen('/storage/'))))->toBeTrue();
});

it('reports public disk write failures instead of returning a broken image path', function () {
    $disk = Mockery::mock(FilesystemAdapter::class);
    $disk->shouldReceive('putFileAs')->once()->andReturn(false);

    Storage::shouldReceive('disk')
        ->once()
        ->with('public')
        ->andReturn($disk);

    expect(fn () => app(ImageService::class)->storeImage(
        UploadedFile::fake()->create('perfume.jpg', 100, 'image/jpeg'),
        'perfumes',
    ))->toThrow(RuntimeException::class, 'Failed to store uploaded image on the public disk.');
});
