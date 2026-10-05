<?php

it('renders public logo assets that are included with the application', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(asset('images/logo.png'), false)
        ->assertSee(asset('images/logo-details.png'), false);

    expect(file_exists(public_path('images/logo.png')))->toBeTrue()
        ->and(file_exists(public_path('images/logo-details.png')))->toBeTrue();
});
