<?php

use App\Models\Perfume;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters the perfume collection by gender', function (string $gender) {
    $matchingPerfume = Perfume::factory()->create(['gender' => $gender]);
    $otherPerfume = Perfume::factory()->create([
        'gender' => match ($gender) {
            'men' => 'women',
            'women' => 'men & women',
            default => 'men',
        },
    ]);

    $this->get(route('perfumes.page', ['gender' => $gender]))
        ->assertOk()
        ->assertSeeText($matchingPerfume->name)
        ->assertDontSeeText($otherPerfume->name);
})->with([
    'men' => ['men'],
    'women' => ['women'],
    'men and women' => ['men & women'],
]);

it('offers gender filtering in both navigation menus', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('data-bs-toggle="dropdown"', false)
        ->assertSee('data-bs-toggle="collapse"', false)
        ->assertSee('data-bs-target="#mobilePerfumeOptions"', false)
        ->assertSee('id="mobilePerfumeOptions"', false)
        ->assertDontSee('href="#" role="button" data-bs-toggle="dropdown"', false)
        ->assertSee(route('perfumes.page', ['gender' => 'men']), false)
        ->assertSee(route('perfumes.page', ['gender' => 'women']), false)
        ->assertSee(route('perfumes.page', ['gender' => 'men & women']), false);
});
