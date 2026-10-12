<?php

use App\Models\Sunglasses;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes the sunglasses product before showing the success message', function () {
    $admin = User::factory()->admin()->create();
    $sunglasses = Sunglasses::factory()->create(['sunglasses_category_id' => null]);

    $this->actingAs($admin)
        ->delete(route('admin.sunglasses.destroy', $sunglasses))
        ->assertRedirect(route('admin.sunglasses.index'))
        ->assertSessionHas('success', 'Sunglasses deleted successfully.');

    $this->assertDatabaseMissing('sunglasses', ['id' => $sunglasses->id]);
});
