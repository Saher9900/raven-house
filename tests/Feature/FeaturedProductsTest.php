<?php

use App\Models\FeaturedProduct;
use App\Models\Perfume;
use App\Models\Sunglasses;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows selected perfumes and sunglasses in order on the homepage', function () {
    $perfume = Perfume::factory()->create(['name' => 'Featured Perfume']);
    $sunglasses = Sunglasses::factory()->create(['name' => 'Featured Sunglasses']);

    FeaturedProduct::query()->create(['perfume_id' => $perfume->id, 'position' => 1]);
    FeaturedProduct::query()->create(['sunglasses_id' => $sunglasses->id, 'position' => 2]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Selected for You')
        ->assertSee('Featured Perfume')
        ->assertSee('Featured Sunglasses')
        ->assertSee(route('perfumes.show', $perfume), false)
        ->assertSee(route('sunglasses.show', $sunglasses), false)
        ->assertSee('See More Products')
        ->assertSee('data-featured-products-swiper', false)
        ->assertSee('data-featured-direction="-1"', false)
        ->assertDontSee('Stock');
});

it('hides the featured products carousel when none are selected', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertDontSee('Selected for You')
        ->assertDontSee('data-featured-products-swiper', false)
        ->assertSee('See More Products');
});

it('localizes featured product labels and the shop button in Arabic', function () {
    $perfume = Perfume::factory()->create(['name' => 'عطر مميز']);
    FeaturedProduct::query()->create(['perfume_id' => $perfume->id]);

    $this->withSession(['locale' => 'ar'])
        ->get(route('home'))
        ->assertOk()
        ->assertSee('<html lang="ar" dir="rtl">', false)
        ->assertSee('مختارة لك')
        ->assertSee('شاهد المزيد من المنتجات')
        ->assertSee('عطر مميز');
});

it('allows admins to add existing perfumes and sunglasses and remove them', function () {
    $admin = User::factory()->admin()->create();
    $perfume = Perfume::factory()->create(['name' => 'Selectable Perfume']);
    $sunglasses = Sunglasses::factory()->create(['name' => 'Selectable Sunglasses']);

    $this->actingAs($admin)
        ->get(route('admin.featured-products.index'))
        ->assertOk()
        ->assertSee('Selectable Perfume')
        ->assertSee('Selectable Sunglasses')
        ->assertSee('Featured Products');

    $this->post(route('admin.featured-products.store'), ['product' => "perfume:{$perfume->id}"])
        ->assertRedirect(route('admin.featured-products.index'));
    $this->post(route('admin.featured-products.store'), ['product' => "sunglasses:{$sunglasses->id}"])
        ->assertRedirect(route('admin.featured-products.index'));

    $this->assertDatabaseHas('featured_products', ['perfume_id' => $perfume->id, 'sunglasses_id' => null]);
    $this->assertDatabaseHas('featured_products', ['sunglasses_id' => $sunglasses->id, 'perfume_id' => null]);

    $featuredProduct = FeaturedProduct::query()->where('perfume_id', $perfume->id)->firstOrFail();

    $this->delete(route('admin.featured-products.destroy', $featuredProduct))
        ->assertRedirect(route('admin.featured-products.index'));

    $this->assertDatabaseMissing('featured_products', ['id' => $featuredProduct->id]);
});

it('rejects missing products and prevents duplicate featured selections', function () {
    $admin = User::factory()->admin()->create();
    $perfume = Perfume::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.featured-products.store'), ['product' => 'perfume:999999'])
        ->assertSessionHasErrors('product');

    $this->post(route('admin.featured-products.store'), ['product' => "perfume:{$perfume->id}"])
        ->assertRedirect(route('admin.featured-products.index'));

    $this->from(route('admin.featured-products.index'))
        ->post(route('admin.featured-products.store'), ['product' => "perfume:{$perfume->id}"])
        ->assertRedirect(route('admin.featured-products.index'))
        ->assertSessionHasErrors('product');

    expect(FeaturedProduct::query()->count())->toBe(1);
});

it('allows admins to change the order of featured products', function () {
    $admin = User::factory()->admin()->create();
    $firstPerfume = Perfume::factory()->create();
    $secondPerfume = Perfume::factory()->create();

    $firstFeatured = FeaturedProduct::query()->create(['perfume_id' => $firstPerfume->id, 'position' => 1]);
    $secondFeatured = FeaturedProduct::query()->create(['perfume_id' => $secondPerfume->id, 'position' => 2]);

    $this->actingAs($admin)
        ->patch(route('admin.featured-products.move', $firstFeatured), ['direction' => 'down'])
        ->assertRedirect(route('admin.featured-products.index'));

    expect($secondFeatured->fresh()->position)->toBe(1)
        ->and($firstFeatured->fresh()->position)->toBe(2);
});

it('restricts featured product management to admins and managers', function () {
    $this->get(route('admin.featured-products.index'))->assertRedirect(route('login'));

    $this->actingAs(User::factory()->create(['role' => 'normal_user']))
        ->get(route('admin.featured-products.index'))
        ->assertForbidden();

    $this->actingAs(User::factory()->manager()->create())
        ->get(route('admin.featured-products.index'))
        ->assertOk();
});

it('removes a featured entry when its product is deleted', function () {
    $perfume = Perfume::factory()->create();
    $featuredProduct = FeaturedProduct::query()->create(['perfume_id' => $perfume->id]);

    $perfume->delete();

    $this->assertDatabaseMissing('featured_products', ['id' => $featuredProduct->id]);
});

it('requires each featured entry to reference exactly one product', function () {
    $perfume = Perfume::factory()->create();
    $sunglasses = Sunglasses::factory()->create();

    expect(fn () => FeaturedProduct::query()->create())
        ->toThrow(QueryException::class);
    expect(fn () => FeaturedProduct::query()->create([
        'perfume_id' => $perfume->id,
        'sunglasses_id' => $sunglasses->id,
    ]))->toThrow(QueryException::class);
});
