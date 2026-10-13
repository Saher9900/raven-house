<?php

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows guests to manage a session-backed cart without creating database cart items', function () {
    $perfume = Perfume::factory()->create(['stock' => 5]);

    $response = $this->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => $perfume->id,
        'quantity' => 2,
    ]);

    $response->assertOk()
        ->assertJsonPath('count', 2)
        ->assertJsonPath('items.0.id', "perfume-{$perfume->id}");

    $this->assertDatabaseCount('cart_items', 0);

    $this->patchJson(route('cart.update', "perfume-{$perfume->id}"), ['quantity' => 3])
        ->assertOk()
        ->assertJsonPath('count', 3);

    $this->deleteJson(route('cart.destroy', "perfume-{$perfume->id}"))
        ->assertOk()
        ->assertJsonPath('count', 0);
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

it('moves a guest session cart into the database cart after login', function () {
    $user = User::factory()->create();
    $perfume = Perfume::factory()->create(['stock' => 5]);

    $this->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => $perfume->id,
        'quantity' => 2,
    ])->assertOk();

    $this->actingAs($user)
        ->getJson(route('cart.index'))
        ->assertOk()
        ->assertJsonPath('count', 2);

    $this->getJson(route('cart.index'))->assertJsonPath('count', 2);

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

it('places an order for a member through the payment and review steps', function () {
    $user = User::factory()->create([
        'phone_number' => '555-0100',
        'shipping_address' => '123 Member Street',
    ]);
    $perfume = Perfume::factory()->create(['stock' => 4, 'price' => 80, 'sale' => 60]);

    CartItem::query()->create([
        'user_id' => $user->id,
        'productable_type' => Perfume::class,
        'productable_id' => $perfume->id,
        'quantity' => 2,
        'unit_price' => 60,
    ]);

    $this->actingAs($user)
        ->postJson(route('checkout.delivery'), ['shipping_address' => '123 Member Street'])
        ->assertOk()
        ->assertJsonPath('redirect', route('checkout.payment'));

    $this->get(route('checkout.payment'))
        ->assertOk()
        ->assertSee('Cash on Delivery');

    $this->post(route('checkout.payment-method'), ['payment_method' => 'cod'])
        ->assertRedirect(route('checkout.review'));

    $this->get(route('checkout.review'))
        ->assertOk()
        ->assertSee($perfume->name)
        ->assertSee('555-0100')
        ->assertSee('name="payment_method"', false);

    $this->post(route('checkout.store'), [
        'customer_name' => $user->name,
        'customer_email' => $user->email,
        'customer_phone' => '555-0100',
        'shipping_address' => '123 Member Street',
        'payment_method' => 'cod',
    ])->assertRedirect(route('perfumes.page'))
        ->assertSessionHas('success');

    $order = Order::query()->first();

    expect($order)->not->toBeNull()
        ->and($order->user_id)->toBe($user->id)
        ->and((float) $order->total)->toBe(120.0)
        ->and($order->status)->toBe('pending')
        ->and($order->payment_method)->toBe('cod')
        ->and($order->items)->toHaveCount(1);

    expect($perfume->fresh()->stock)->toBe(2);
    expect(CartItem::query()->count())->toBe(0);
});

it('places an order for a guest through the payment and review steps', function () {
    $perfume = Perfume::factory()->create(['stock' => 4, 'price' => 80, 'sale' => 60]);

    $this->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => $perfume->id,
        'quantity' => 2,
    ])->assertOk();

    $this->postJson(route('checkout.delivery'), [
        'customer_name' => 'Guest Customer',
        'customer_phone' => '555-0100',
        'shipping_address' => '123 Market Street',
    ])->assertOk()
        ->assertJsonPath('redirect', route('checkout.payment'));

    $this->post(route('checkout.payment-method'), ['payment_method' => 'cod'])
        ->assertRedirect(route('checkout.review'));

    $this->get(route('checkout.review'))
        ->assertOk()
        ->assertSee($perfume->name)
        ->assertSee('name="payment_method"', false);

    $this->post(route('checkout.store'), [
        'customer_name' => 'Guest Customer',
        'customer_email' => null,
        'customer_phone' => '555-0100',
        'shipping_address' => '123 Market Street',
        'payment_method' => 'cod',
    ])->assertRedirect(route('perfumes.page'))
        ->assertSessionHas('success');

    $order = Order::query()->first();

    expect($order)->not->toBeNull()
        ->and($order->user_id)->toBeNull()
        ->and($order->customer_name)->toBe('Guest Customer')
        ->and($order->customer_email)->toBeNull()
        ->and($order->customer_phone)->toBe('555-0100')
        ->and($order->shipping_address)->toBe('123 Market Street')
        ->and((float) $order->total)->toBe(120.0)
        ->and($order->payment_method)->toBe('cod')
        ->and($order->items)->toHaveCount(1);

    expect($perfume->fresh()->stock)->toBe(2);
    $this->assertDatabaseCount('cart_items', 0);
    $this->getJson(route('cart.index'))->assertJsonPath('count', 0);
});

it('requires all contact details and a payment method before placing a guest order', function () {
    $perfume = Perfume::factory()->create(['stock' => 2]);

    $this->postJson(route('cart.store'), [
        'product_type' => 'perfume',
        'product_id' => $perfume->id,
    ])->assertOk();

    $this->postJson(route('checkout.store'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'customer_name',
            'customer_phone',
            'shipping_address',
            'payment_method',
        ]);

    expect(Order::query()->count())->toBe(0)
        ->and($perfume->fresh()->stock)->toBe(2);
});

it('guards the payment page until delivery details are stored', function () {
    $this->get(route('checkout.payment'))
        ->assertRedirect(route('cart.index'));
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
