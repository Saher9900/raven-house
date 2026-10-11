<?php

use App\Services\ImageService;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores uploaded images on the S3 disk and returns their object key', function () {
    Storage::fake('s3');

    $imagePath = app(ImageService::class)->storeImage(
        UploadedFile::fake()->create('perfume.jpg', 100, 'image/jpeg'),
        'perfumes',
    );

    expect($imagePath)->toStartWith('images/perfumes/');
    expect(Storage::disk('s3')->exists($imagePath))->toBeTrue();
});

it('reports S3 write failures instead of returning a broken image path', function () {
    $disk = Mockery::mock(FilesystemAdapter::class);
    $disk->shouldReceive('putFileAs')->once()->andReturn(false);

    Storage::shouldReceive('disk')
        ->once()
        ->with('s3')
        ->andReturn($disk);

    expect(fn () => app(ImageService::class)->storeImage(
        UploadedFile::fake()->create('perfume.jpg', 100, 'image/jpeg'),
        'perfumes',
    ))->toThrow(RuntimeException::class, 'Failed to store uploaded image on the S3 disk.');
});

it('deletes uploaded images from their original disk while keeping defaults', function () {
    Storage::fake('s3');
    Storage::fake('public');

    Storage::disk('s3')->put('images/perfumes/product.jpg', 'image');
    Storage::disk('public')->put('images/default-product.png', 'default');

    $imageService = app(ImageService::class);
    $imageService->deleteImage('images/perfumes/product.jpg');
    $imageService->deleteImage('/storage/images/default-product.png');

    expect(Storage::disk('s3')->exists('images/perfumes/product.jpg'))->toBeFalse();
    expect(Storage::disk('public')->exists('images/default-product.png'))->toBeTrue();
});
