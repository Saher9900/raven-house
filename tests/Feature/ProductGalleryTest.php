<?php

use App\Models\Perfume;
use App\Models\Sunglasses;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('makes perfume thumbnails selectable in the main image frame', function () {
    $perfume = Perfume::factory()->create();
    $perfume->images()->createMany([
        ['image_path' => 'perfumes/front.jpg'],
        ['image_path' => 'perfumes/side.jpg'],
    ]);

    $this->get(route('perfumes.show', $perfume))
        ->assertOk()
        ->assertSee('id="perfume-product-image"', false)
        ->assertSee('data-gallery-target="perfume-product-image"', false)
        ->assertSee('data-gallery-image="'.asset('perfumes/side.jpg').'"', false)
        ->assertSee('aria-pressed="true"', false)
        ->assertSee('aria-pressed="false"', false);
});

it('makes sunglasses thumbnails selectable in the main image frame', function () {
    $sunglasses = Sunglasses::factory()->create();
    $sunglasses->images()->createMany([
        ['image_path' => 'sunglasses/front.jpg'],
        ['image_path' => 'sunglasses/side.jpg'],
    ]);

    $this->get(route('sunglasses.show', $sunglasses))
        ->assertOk()
        ->assertSee('id="sunglasses-product-image"', false)
        ->assertSee('data-gallery-target="sunglasses-product-image"', false)
        ->assertSee('data-gallery-image="'.asset('sunglasses/side.jpg').'"', false)
        ->assertSee('aria-pressed="true"', false)
        ->assertSee('aria-pressed="false"', false);
});
