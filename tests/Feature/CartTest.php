<?php

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires authentication to manage the cart', function () {
    $this->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => 1,
    ])->assertUnauthorized();
});

it('adds a product to the cart for a logged in user', function () {
    $user = User::factory()->create();
    $perfume = Perfume::factory()->create(['stock' => 5, 'price' => 120, 'sale' => null]);

    $response = $this->actingAs($user)->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => $perfume->id,
        'quantity' => 2,
    ]);

    $response->assertOk()
        ->assertJsonPath('count', 2)
        ->assertJsonPath('items.0.name', $perfume->name);

    $this->assertDatabaseHas('cart_items', [
        'user_id' => $user->id,
        'productable_type' => Perfume::class,
        'productable_id' => $perfume->id,
        'quantity' => 2,
    ]);
});

it('updates and removes cart items', function () {
    $user = User::factory()->create();
    $perfume = Perfume::factory()->create(['stock' => 5]);

    $cartItem = CartItem::query()->create([
        'user_id' => $user->id,
        'productable_type' => Perfume::class,
        'productable_id' => $perfume->id,
        'quantity' => 1,
        'unit_price' => $perfume->effectivePrice(),
    ]);

    $this->actingAs($user)
        ->patchJson(route('cart.update', $cartItem), ['quantity' => 3])
        ->assertOk()
        ->assertJsonPath('count', 3);

    $this->actingAs($user)
        ->deleteJson(route('cart.destroy', $cartItem))
        ->assertOk()
        ->assertJsonPath('count', 0);

    $this->assertDatabaseMissing('cart_items', ['id' => $cartItem->id]);
});

it('creates an order in the dashboard when checking out', function () {
    $user = User::factory()->create();
    $perfume = Perfume::factory()->create(['stock' => 4, 'price' => 80, 'sale' => 60]);

    CartItem::query()->create([
        'user_id' => $user->id,
        'productable_type' => Perfume::class,
        'productable_id' => $perfume->id,
        'quantity' => 2,
        'unit_price' => 60,
    ]);

    $response = $this->actingAs($user)->postJson(route('checkout.store'));

    $response->assertOk()
        ->assertJsonPath('count', 0);

    $order = Order::query()->first();

    expect($order)->not->toBeNull()
        ->and($order->user_id)->toBe($user->id)
        ->and((float) $order->total)->toBe(120.0)
        ->and($order->status)->toBe('pending')
        ->and($order->items)->toHaveCount(1);

    expect($perfume->fresh()->stock)->toBe(2);
    expect(CartItem::query()->count())->toBe(0);
});

it('allows admins to view orders in the dashboard', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();
    $perfume = Perfume::factory()->create();

    $order = Order::query()->create([
        'user_id' => $customer->id,
        'status' => 'pending',
        'total' => 80,
        'customer_name' => $customer->name,
        'customer_email' => $customer->email,
    ]);

    $order->items()->create([
        'productable_type' => Perfume::class,
        'productable_id' => $perfume->id,
        'product_name' => $perfume->name,
        'product_brand' => $perfume->brand,
        'product_type' => 'Perfume',
        'quantity' => 1,
        'unit_price' => 80,
        'subtotal' => 80,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.orders.index'))
        ->assertOk()
        ->assertSee((string) $order->id)
        ->assertSee($customer->name);
});
