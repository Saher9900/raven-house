<?php

use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters the perfume collection by type', function (string $type) {
    $matchingPerfume = Perfume::factory()->create(['perfume_type' => $type]);
    $otherPerfume = Perfume::factory()->create([
        'perfume_type' => match ($type) {
            'box' => 'fragrance',
            default => 'box',
        },
    ]);

    $this->get(route('perfumes.page', ['perfume_type' => $type]))
        ->assertOk()
        ->assertDontSee('id="perfume_type"', false)
        ->assertSeeText($matchingPerfume->name)
        ->assertDontSeeText($otherPerfume->name);
})->with([
    'boxes' => ['box'],
    'fragrance' => ['fragrance'],
]);

it('renders an order now button on each perfume card', function () {
    $perfume = Perfume::factory()->create(['stock' => 3]);

    $this->get(route('perfumes.page'))
        ->assertOk()
        ->assertSee('Order Now')
        ->assertSee('class="btn btn-outline-gold btn-sm rounded-pill w-100 mt-2 order-now-btn"', false)
        ->assertSee('data-product-id="'.$perfume->id.'"', false);
});

it('does not display stock counts on perfume pages', function () {
    $perfume = Perfume::factory()->create([
        'name' => 'Hidden Quantity Test',
        'stock' => 37,
        'perfume_type' => 'box',
    ]);

    $this->get(route('perfumes.page'))
        ->assertOk()
        ->assertSeeText('Box')
        ->assertDontSeeText('Stock:');

    $this->get(route('perfumes.show', $perfume))
        ->assertOk()
        ->assertSeeText('Box')
        ->assertDontSeeText('Stock');
});

it('offers perfume type filtering in both navigation menus', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-bs-toggle="dropdown"', false)
        ->assertSee('data-bs-toggle="collapse"', false)
        ->assertSee('data-bs-target="#mobilePerfumeOptions"', false)
        ->assertSee('id="mobilePerfumeOptions"', false)
        ->assertDontSee('href="#" role="button" data-bs-toggle="dropdown"', false)
        ->assertSee(route('perfumes.page', ['perfume_type' => 'box']), false)
        ->assertSee(route('perfumes.page', ['perfume_type' => 'fragrance']), false);
});

it('offers box and fragrance collections on the shop page', function () {
    $this->get(route('shop.page'))
        ->assertOk()
        ->assertSee(route('perfumes.page', ['perfume_type' => 'box']), false)
        ->assertSee(route('perfumes.page', ['perfume_type' => 'fragrance']), false)
        ->assertSeeText('Boxes')
        ->assertSeeText('Fragrances');
});
