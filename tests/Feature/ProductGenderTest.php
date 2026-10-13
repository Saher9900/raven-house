<?php

use App\Models\Perfume;
use App\Models\PerfumesCategory;
use App\Models\Sunglasses;
use App\Models\SunglassesCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows the new nullable gender values for both product types and rejects legacy values', function () {
    $admin = User::factory()->admin()->create();
    $products = [
        [
            Perfume::class,
            PerfumesCategory::factory()->create()->id,
            'perfumes_category_id',
            'perfumes',
        ],
        [
            Sunglasses::class,
            SunglassesCategory::factory()->create()->id,
            'sunglasses_category_id',
            'sunglasses',
        ],
    ];

    foreach ($products as [$model, $categoryId, $categoryColumn, $routePrefix]) {
        $product = $model::factory()->create([
            $categoryColumn => $categoryId,
            'gender' => null,
        ]);

        $data = [
            $categoryColumn => $categoryId,
            'name' => $product->name,
            'price' => $product->price,
            'brand' => $product->brand,
            'description' => $product->description,
            'sale' => $product->sale,
            'stock' => $product->stock,
        ];

        foreach (['men', 'women', 'men & women', null] as $gender) {
            $this->actingAs($admin)
                ->put(route("admin.{$routePrefix}.update", $product), [...$data, 'gender' => $gender])
                ->assertRedirect(route("admin.{$routePrefix}.index"));

            $this->assertDatabaseHas($product->getTable(), [
                'id' => $product->id,
                'gender' => $gender,
            ]);
        }

        $this->actingAs($admin)
            ->put(route("admin.{$routePrefix}.update", $product), [...$data, 'gender' => 'male'])
            ->assertSessionHasErrors('gender');
    }
});
