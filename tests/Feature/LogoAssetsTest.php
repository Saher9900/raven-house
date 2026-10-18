<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders public logo assets that are included with the application', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(asset('images/logo.png'), false)
        ->assertSee('<link rel="icon" type="image/png" href="'.asset('images/logo.png').'" />', false);

    expect(file_exists(public_path('images/logo.png')))->toBeTrue()
        ->and(file_exists(public_path('images/logo-details.png')))->toBeTrue();
});
