@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <p class="section-eyebrow">Premium Eyewear</p>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <h1 class="font-display display-4 fw-bold text-white mt-3">Sunglasses</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-2">UV protection meets sculptural design — frames built to
                    last seasons, not weeks.</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <form action="{{ route('sunglasses.page') }}" method="GET"
                    class="card-raven filter-bar rounded-4 p-4 p-lg-5 mb-5">
                    <p class="filter-bar__title mb-0">Refine Collection</p>
                    <div class="row g-4 align-items-end">
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select input-dark rounded-3" id="category" name="category">
                                <option value="">All categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="name" class="form-label">Product name</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start-3">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.06a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z"/>
                                    </svg>
                                </span>
                                <input type="search" class="form-control input-dark rounded-end-3" id="name" name="name"
                                    value="{{ request('name') }}" placeholder="Search by name">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sort" class="form-label">Sort by price</label>
                            <select class="form-select input-dark rounded-3" id="sort" name="sort">
                                <option value="">Default order</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>Low to High</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>High to Low</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2 pt-1">
                            <button type="submit" class="btn btn-gold rounded-pill px-4">Apply filters</button>
                            @if(request()->hasAny(['category', 'name', 'sort']))
                                <a href="{{ route('sunglasses.page') }}"
                                    class="btn btn-filter rounded-pill px-4">Clear filters</a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="row g-4">
                    @forelse($sunglasses as $glass)
                        <div class="col-sm-6 col-lg-4">
                            <article class="product-card rounded-4 overflow-hidden h-100">
                                <div
                                    class="product-visual bg-raven-surface d-flex align-items-center justify-content-center p-4">
                                    @if($glass->images->first())
                                        <img src="{{ asset($glass->images->first()->image_path) }}" alt="{{ $glass->name }}"
                                            class="w-100 h-100 object-fit-cover">
                                    @else
                                        <svg class="w-100 text-gold opacity-50" style="max-width:200px" viewBox="0 0 120 40"
                                            fill="none" stroke="currentColor" stroke-width="1.2">
                                            <path d="M10 20 Q30 5 60 20 Q90 5 110 20" stroke-linecap="round" />
                                            <ellipse cx="30" cy="22" rx="22" ry="14" />
                                            <ellipse cx="90" cy="22" rx="22" ry="14" />
                                            <path d="M52 22 h16" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <span class="text-gold text-uppercase small opacity-75">
                                        {{ $glass->category?->name ?? 'Uncategorized' }}
                                    </span>
                                    <h2 class="font-display h3 fw-semibold text-white mt-1">{{ $glass->name }}</h2>
                                    <p class="text-secondary small mb-0">{{ $glass->brand }}</p>
                                    <div class="mt-3 mb-0">
                                        @if($glass->sale)
                                            <p class="text-gold fs-5 fw-medium mb-0">
                                                <span class="text-decoration-line-through text-muted-raven small">${{ number_format($glass->price, 2) }}</span>
                                                <span class="ms-2">${{ number_format($glass->sale, 2) }}</span>
                                            </p>
                                        @else
                                            <p class="text-gold fs-5 fw-medium mb-0">${{ number_format($glass->price, 2) }}</p>
                                        @endif
                                    </div>
                                    <p class="text-muted-raven small mt-2 mb-0">
                                        Stock: <strong>{{ $glass->stock }}</strong> | {{ ucfirst($glass->gender) }}
                                    </p>
                                    <div class="d-flex gap-2 mt-3">
                                        <a href="{{ route('sunglasses.show', $glass) }}" class="btn btn-outline-gold btn-sm rounded-pill flex-grow-1">
                                            View Details
                                        </a>
                                        @auth
                                            <button type="button"
                                                class="btn btn-gold btn-sm rounded-pill add-to-cart-btn"
                                                data-product-type="sunglasses"
                                                data-product-id="{{ $glass->id }}"
                                                @disabled($glass->stock < 1)
                                                title="{{ $glass->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/>
                                                </svg>
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-gold btn-sm rounded-pill">
                                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2z"/>
                                                </svg>
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted-raven">
                                @if(request()->hasAny(['category', 'name', 'sort']))
                                    No sunglasses match your filters.
                                @else
                                    No sunglasses available at the moment.
                                @endif
                            </p>
                        </div>
                    @endforelse
                </div>

                @if($sunglasses->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $sunglasses->links() }}
                    </div>
                @endif

                <p class="text-center text-muted-raven small mt-5">Need help choosing a fit? <a href="{{ route('contact.page') }}"
                        class="text-gold">Book a consultation</a>.</p>
            </div>
        </section>
    </main>
@endsection
