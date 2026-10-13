<?php

it('persists the selected language and renders the arabic about page right to left', function () {
    $this->from(route('about.page'))
        ->post(route('language.update', 'ar'))
        ->assertRedirect(route('about.page'))
        ->assertSessionHas('locale', 'ar');

    $this->get(route('about.page'))
        ->assertOk()
        ->assertSee('<html lang="ar" dir="rtl">', false)
        ->assertSee('رؤيتنا')
        ->assertDontSee('Mission')
        ->assertDontSee('Values')
        ->assertDontSee('Promise')
        ->assertDontSee('Crafted With Care');
});

it('shows the raven portrait and only the requested signature in the home marquee', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Details chosen with care, to reflect a distinctive personality and an unforgettable presence.')
        ->assertSee('We waited for his arrival, and captured the moment.')
        ->assertSee('A living portrait of the Raven House raven')
        ->assertSee('A signature of presence')
        ->assertSee('Check Our Perfumes')
        ->assertSee(route('perfumes.page'), false)
        ->assertDontSee('The Raven House Manifesto')
        ->assertDontSee('Our Collections')
        ->assertDontSee('Why Raven House')
        ->assertDontSee('Begin Your Journey')
        ->assertDontSee('logo-details.png');
});

it('shows the updated contact details without the boutique, email, or message form', function () {
    $this->get(route('contact.page'))
        ->assertOk()
        ->assertSee('Reach Out to Us')
        ->assertSee('+20 106 204 4462')
        ->assertSee('Available 24 hours')
        ->assertSee('Instagram')
        ->assertSee('Facebook')
        ->assertDontSee('Visit the Boutique')
        ->assertDontSee('hello@ravenhouse.com')
        ->assertDontSee('Send a Message');
});

it('switches back to english from the language control', function () {
    $this->withSession(['locale' => 'ar'])
        ->from(route('contact.page'))
        ->post(route('language.update', 'en'))
        ->assertRedirect(route('contact.page'))
        ->assertSessionHas('locale', 'en');

    $this->get(route('contact.page'))
        ->assertSee('<html lang="en" dir="ltr">', false)
        ->assertSee('Reach Out to Us');
});

it('does not allow unsupported locales', function () {
    $this->post(route('language.update', 'fr'))
        ->assertNotFound();
});
