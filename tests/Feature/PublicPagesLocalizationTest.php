<?php

use App\Models\Perfume;
use App\Models\Sunglasses;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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

it('shows the raven portrait, marquee, and updated homepage calls to action', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('We waited for his arrival, and captured the moment.')
        ->assertSee('A living portrait of the Raven House raven')
        ->assertSee('A signature of presence')
        ->assertSee('Discover the World of Raven House')
        ->assertSee('See More Products')
        ->assertDontSee('Why Raven House')
        ->assertSee(route('perfumes.page'), false)
        ->assertDontSee('The Raven House Manifesto')
        ->assertDontSee('Our Collections')
        ->assertDontSee('Begin Your Journey')
        ->assertDontSee('logo-details.png');
});

it('shows the raven story, vision, and why Raven House only on the about page', function () {
    $this->get(route('about.page'))
        ->assertOk()
        ->assertSee('Why the Raven?')
        ->assertSee('Our Vision')
        ->assertSee('Why Raven House')
        ->assertSee('about-hero__title', false)
        ->assertSee('about-vision__card', false)
        ->assertSee('reveal-delay-3', false);

    $this->withSession(['locale' => 'ar'])
        ->get(route('about.page'))
        ->assertOk()
        ->assertSee('لماذا الغراب؟')
        ->assertSee('رؤيتنا')
        ->assertSee('لماذا Raven House')
        ->assertSee('الغراب لا يمتلك مخالب النسر')
        ->assertSee('لكل رجل شخصية تستحق أن تنعكس في أدق تفاصيله');
});

it('shows the updated contact details without the boutique, email, or message form', function () {
    $this->get(route('contact.page'))
        ->assertOk()
        ->assertSee('Reach Out to Us')
        ->assertDontSee('+20 106 204 4462')
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

it('translates the perfume listing chrome but leaves catalogue data untouched', function () {
    $perfume = Perfume::factory()->create([
        'name' => 'Noir Absolu',
        'perfume_type' => 'fragrance',
        'stock' => 4,
    ]);
    Perfume::factory()->create([
        'name' => 'Gift Set',
        'perfume_type' => 'box',
    ]);

    $this->withSession(['locale' => 'ar'])
        ->get(route('perfumes.page'))
        ->assertOk()
        ->assertSee('العطور')
        ->assertSee('تصفية المجموعة')
        ->assertSee('تطبيق التصفية')
        ->assertSee('أضف إلى السلة')
        ->assertSee('عرض التفاصيل')
        ->assertSee('صندوق')
        ->assertDontSee('المخزون')
        // Catalogue data is authored once and rendered as stored in every locale.
        ->assertSee('Noir Absolu')
        ->assertDontSee('Refine Collection')
        ->assertDontSee('Apply filters')
        ->assertDontSee('View Details');
});

it('does not invite the visitor to a private consultation on the perfume listing', function () {
    $this->get(route('perfumes.page'))
        ->assertOk()
        ->assertDontSee('Interested in a private consultation?')
        ->assertDontSee('Get in touch');
});

it('translates the perfume detail page', function () {
    $perfume = Perfume::factory()->create([
        'name' => 'Noir Absolu',
        'perfume_type' => 'fragrance',
    ]);

    $this->withSession(['locale' => 'ar'])
        ->get(route('perfumes.show', $perfume))
        ->assertOk()
        ->assertSee('→ العودة إلى العطور')
        ->assertSee('الوصف')
        ->assertSee('العطور')
        ->assertSee('نوع العطر')
        ->assertSee('أضف إلى السلة')
        ->assertSee('Noir Absolu')
        ->assertDontSee('Back to Perfumes')
        // The template's HTML section comments keep the English labels, so assert on
        // rendered copy instead: a missing translation key renders as its dotted name.
        ->assertDontSee('website.');
});

it('translates the sunglasses coming soon page', function () {
    $this->withSession(['locale' => 'ar'])
        ->get(route('sunglasses.page'))
        ->assertOk()
        ->assertSee('قريبًا')
        ->assertDontSee('Coming Soon');
});

it('translates the sunglasses detail page', function () {
    $sunglasses = Sunglasses::factory()->create([
        'name' => 'Aviator Noir',
        'gender' => 'men & women',
    ]);

    $this->withSession(['locale' => 'ar'])
        ->get(route('sunglasses.show', $sunglasses))
        ->assertOk()
        ->assertSee('→ العودة إلى النظارات الشمسية')
        ->assertSee('رجال ونساء')
        ->assertDontSee('المخزون')
        ->assertSee('Aviator Noir')
        ->assertDontSee('Back to Sunglasses')
        ->assertDontSee('Not specified');
});

it('translates the login and register pages', function () {
    $this->withSession(['locale' => 'ar'])
        ->get(route('login'))
        ->assertOk()
        ->assertSee('أهلًا بعودتك')
        ->assertSee('البريد الإلكتروني')
        ->assertSee('كلمة المرور')
        ->assertSee('تذكرني')
        ->assertDontSee('Welcome Back')
        ->assertDontSee('Remember me');

    $this->withSession(['locale' => 'ar'])
        ->get(route('register'))
        ->assertOk()
        ->assertSee('انضم إلى Raven House')
        ->assertSee('إنشاء حساب')
        ->assertSee('رقم الهاتف')
        ->assertSee('تأكيد كلمة المرور')
        ->assertSee('عنوان الشحن (اختياري)')
        ->assertDontSee('Join Raven House')
        ->assertDontSee('Confirm password');
});
