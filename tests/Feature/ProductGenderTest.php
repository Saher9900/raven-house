<?php

use App\Models\Perfume;
use App\Models\PerfumesCategory;
use App\Models\Sunglasses;
use App\Models\SunglassesCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows only perfume type values for perfumes', function () {
    $admin = User::factory()->admin()->create();
    $category = PerfumesCategory::factory()->create();
    $perfume = Perfume::factory()->create([
        'perfumes_category_id' => $category->id,
        'perfume_type' => null,
    ]);

    $data = [
        'perfumes_category_id' => $category->id,
        'name' => $perfume->name,
        'price' => $perfume->price,
        'brand' => $perfume->brand,
        'description' => $perfume->description,
        'sale' => $perfume->sale,
        'stock' => $perfume->stock,
    ];

    foreach (['box', 'fragrance', null] as $type) {
        $this->actingAs($admin)
            ->put(route('admin.perfumes.update', $perfume), [...$data, 'perfume_type' => $type])
            ->assertRedirect(route('admin.perfumes.index'));

        $this->assertDatabaseHas('perfumes', [
            'id' => $perfume->id,
            'perfume_type' => $type,
        ]);
    }

    $this->actingAs($admin)
        ->put(route('admin.perfumes.update', $perfume), [...$data, 'perfume_type' => 'men'])
        ->assertSessionHasErrors('perfume_type');
});

it('keeps the existing nullable gender values for sunglasses', function () {
    $admin = User::factory()->admin()->create();
    $category = SunglassesCategory::factory()->create();
    $sunglasses = Sunglasses::factory()->create([
        'sunglasses_category_id' => $category->id,
        'gender' => null,
    ]);

    $data = [
        'sunglasses_category_id' => $category->id,
        'name' => $sunglasses->name,
        'price' => $sunglasses->price,
        'brand' => $sunglasses->brand,
        'description' => $sunglasses->description,
        'sale' => $sunglasses->sale,
        'stock' => $sunglasses->stock,
    ];

    foreach (['men', 'women', 'men & women', null] as $gender) {
        $this->actingAs($admin)
            ->put(route('admin.sunglasses.update', $sunglasses), [...$data, 'gender' => $gender])
            ->assertRedirect(route('admin.sunglasses.index'));

        $this->assertDatabaseHas('sunglasses', [
            'id' => $sunglasses->id,
            'gender' => $gender,
        ]);
    }

    $this->actingAs($admin)
        ->put(route('admin.sunglasses.update', $sunglasses), [...$data, 'gender' => 'male'])
        ->assertSessionHasErrors('gender');
});
