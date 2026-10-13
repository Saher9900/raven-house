@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <h1 class="font-display display-4 fw-bold text-white mt-3">{{ __('website.perfumes.title') }}</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-2">{{ __('website.perfumes.subtitle') }}</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <form action="{{ route('perfumes.page') }}" method="GET"
                    class="card-raven filter-bar rounded-4 p-4 p-lg-5 mb-5">
                    <p class="filter-bar__title mb-0">{{ __('website.perfumes.refine') }}</p>
                    <div class="row g-4 align-items-end">
                        <div class="col-md-4">
                            <label for="gender" class="form-label">{{ __('website.perfumes.filter_gender') }}</label>
                            <select class="form-select input-dark rounded-3" id="gender" name="gender">
                                <option value="">{{ __('website.perfumes.all_genders') }}</option>
                                <option value="men" @selected(request('gender') === 'men')>{{ __('website.gender.men') }}</option>
                                <option value="women" @selected(request('gender') === 'women')>{{ __('website.gender.women') }}</option>
                                <option value="men & women" @selected(request('gender') === 'men & women')>{{ __('website.gender.men_and_women') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">{{ __('website.perfumes.filter_category') }}</label>
                            <select class="form-select input-dark rounded-3" id="category" name="category">
                                <option value="">{{ __('website.perfumes.all_categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="name" class="form-label">{{ __('website.perfumes.filter_name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-3">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.06a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                                    </svg>
                                </span>
                                <input type="search" class="form-control input-dark rounded-end-3" id="name" name="name"
                                    value="{{ request('name') }}" placeholder="{{ __('website.perfumes.search_placeholder') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sort" class="form-label">{{ __('website.perfumes.sort_by_price') }}</label>
                            <select class="form-select input-dark rounded-3" id="sort" name="sort">
                                <option value="">{{ __('website.perfumes.default_order') }}</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>{{ __('website.perfumes.price_low_high') }}</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>{{ __('website.perfumes.price_high_low') }}</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2 pt-1">
                            <button type="submit" class="btn btn-gold rounded-pill px-4">{{ __('website.perfumes.apply_filters') }}</button>
                            @if(request()->hasAny(['gender', 'category', 'name', 'sort']))
                                <a href="{{ route('perfumes.page') }}"
                                    class="btn btn-filter rounded-pill px-4">{{ __('website.perfumes.clear_filters') }}</a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="row g-4">
                    @forelse($perfumes as $perfume)
                        <div class="col-sm-6 col-lg-4">
                            <article class="product-card rounded-4 overflow-hidden h-100">
                                <div class="product-visual d-flex align-items-center justify-content-center"
                                    style="background: linear-gradient(to bottom, rgba(69,26,3,0.4), #09090b);">
                                    @if($perfume->images->first())
                                        <img src="{{ asset($perfume->images->first()->image_path) }}" alt="{{ $perfume->name }}"
                                            class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="perfume-bottle"></div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <span class="text-gold text-uppercase small opacity-75">
                                        {{ $perfume->category?->name ?? __('website.product.uncategorized') }}
                                    </span>
                                    <h2 class="font-display h3 fw-semibold text-white mt-1">{{ $perfume->name }}</h2>
                                    <p class="text-secondary small mb-0">{{ $perfume->brand }}</p>
                                    <div class="mt-3 mb-0">
                                        @if($perfume->sale)
                                            <p class="text-gold fs-5 fw-medium mb-0">
                                                <span class="text-decoration-line-through text-muted-raven small">${{ number_format($perfume->price, 2) }}</span>
                                                <span class="ms-2">${{ number_format($perfume->sale, 2) }}</span>
                                            </p>
                                        @else
                                            <p class="text-gold fs-5 fw-medium mb-0">${{ number_format($perfume->price, 2) }}</p>
                                        @endif
                                    </div>
                                    <p class="text-muted-raven small mt-2 mb-0">
                                        {{ __('website.product.stock') }}: <strong>{{ $perfume->stock }}</strong> |
                                        {{ __(match ($perfume->gender) {
                                            'men' => 'website.gender.men',
                                            'women' => 'website.gender.women',
                                            'men & women' => 'website.gender.men_and_women',
                                            default => 'website.perfumes.gender_unspecified',
                                        }) }}
                                    </p>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('perfumes.show', $perfume) }}" class="btn btn-outline-gold btn-sm rounded-pill flex-grow-1">
                                            {{ __('website.product.view_details') }}
                                        </a>
                                        @auth
                                            <button type="button"
                                                class="btn btn-gold btn-sm rounded-pill add-to-cart-btn"
                                                data-product-type="perfume"
                                                data-product-id="{{ $perfume->id }}"
                                                @disabled($perfume->stock < 1)
                                                title="{{ $perfume->stock < 1 ? __('website.product.out_of_stock') : __('website.product.add_to_cart') }}">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="button"
                                                class="btn btn-gold btn-sm rounded-pill add-to-cart-btn"
                                                data-product-type="perfume"
                                                data-product-id="{{ $perfume->id }}"
                                                @disabled($perfume->stock < 1)
                                                title="{{ $perfume->stock < 1 ? __('website.product.out_of_stock') : __('website.product.add_to_cart') }}">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/>
                                                </svg>
                                            </button>
                                        @endauth
                                    </div>
                                    <button type="button"
                                        class="btn btn-outline-gold btn-sm rounded-pill w-100 mt-2 order-now-btn"
                                        data-product-type="perfume"
                                        data-product-id="{{ $perfume->id }}"
                                        @disabled($perfume->stock < 1)>
                                        {{ __('website.general.order_now') }}
                                    </button>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted-raven">
                                @if(request()->hasAny(['category', 'name', 'sort']))
                                    {{ __('website.perfumes.no_results') }}
                                @else
                                    {{ __('website.perfumes.no_products') }}
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>

                @if($perfumes->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $perfumes->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
