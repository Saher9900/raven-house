@extends('website.layout.main')
@section('content')
    <main class="product-detail-page">
        <section class="pb-5">
            <div class="container">
                <a href="{{ route('sunglasses.page') }}" class="btn btn-outline-gold rounded-pill px-4 mb-4">
                    ← Back to Sunglasses
                </a>

                <div class="row g-5">
                    <!-- Product Images -->
                    <div class="col-lg-5">
                        <div class="product-visual product-detail-visual rounded-4 overflow-hidden mb-4 bg-raven-surface d-flex align-items-center justify-content-center p-4">
                            @if($sunglasses->images->first())
                                <img src="{{ asset($sunglasses->images->first()->image_path) }}" alt="{{ $sunglasses->name }}"
                                    class="w-100 h-100 product-detail-image">
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

                        @if($sunglasses->images->count() > 1)
                            <div class="row g-3">
                                @foreach($sunglasses->images as $image)
                                    <div class="col-4">
                                        <div class="rounded-3 overflow-hidden cursor-pointer bg-raven-surface d-flex align-items-center justify-content-center" style="height: 100px;">
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $sunglasses->name }}"
                                                class="w-100 h-100 object-fit-cover">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="col-lg-7">
                        <span class="text-gold text-uppercase small opacity-75">
                            {{ $sunglasses->category?->name ?? 'Uncategorized' }}
                        </span>

                        <h1 class="font-display display-5 fw-bold text-white mt-3 mb-2">{{ $sunglasses->name }}</h1>
                        <p class="text-secondary fs-5 mb-4">{{ $sunglasses->brand }}</p>

                        <!-- Price -->
                        <div class="mb-4">
                            @if($sunglasses->sale)
                                <p class="text-gold fs-3 fw-bold mb-0">
                                    <span class="text-decoration-line-through text-muted-raven">${{ number_format($sunglasses->price, 2) }}</span>
                                    <span class="ms-3">${{ number_format($sunglasses->sale, 2) }}</span>
                                </p>
                            @else
                                <p class="text-gold fs-3 fw-bold mb-0">${{ number_format($sunglasses->price, 2) }}</p>
                            @endif
                        </div>

                        <!-- Product Info Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="card bg-raven-surface border-gold rounded-3">
                                    <div class="card-body">
                                        <p class="text-gold small text-uppercase mb-2">Gender</p>
                                        <p class="text-white fw-semibold mb-0">{{ ucfirst($sunglasses->gender) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-raven-surface border-gold rounded-3">
                                    <div class="card-body">
                                        <p class="text-gold small text-uppercase mb-2">Stock</p>
                                        <p class="text-white fw-semibold mb-0">
                                            @if($sunglasses->stock > 0)
                                                {{ $sunglasses->stock }} Available
                                            @else
                                                <span class="text-danger">Out of Stock</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($sunglasses->description)
                            <div class="mb-4">
                                <h5 class="text-gold mb-3">Description</h5>
                                <p class="text-muted-raven">{{ $sunglasses->description }}</p>
                            </div>
                        @endif

                        <!-- Add to Cart -->
                        @auth
                            <button type="button"
                                class="btn btn-gold btn-lg rounded-pill px-5 w-100 add-to-cart-btn"
                                data-product-type="sunglasses"
                                data-product-id="{{ $sunglasses->id }}"
                                @disabled($sunglasses->stock < 1)>
                                <span class="fs-5">
                                    {{ $sunglasses->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
                                </span>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-gold btn-lg rounded-pill px-5 w-100">
                                <span class="fs-5">Login to Add to Cart</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <section class="py-5 section-muted">
                <div class="container">
                    <div class="text-center mb-5">
                        <p class="section-eyebrow mb-3">Similar Styles</p>
                        <h2 class="font-display section-title fw-semibold text-white">Related Sunglasses</h2>
                        <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                    </div>

                    <div class="row g-4">
                        @foreach($relatedProducts as $product)
                            <div class="col-sm-6 col-lg-4">
                                <article class="product-card rounded-4 overflow-hidden h-100">
                                    <div class="product-visual bg-raven-surface d-flex align-items-center justify-content-center p-4">
                                        @if($product->images->first())
                                            <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}"
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
                                            {{ $product->category?->name ?? 'Uncategorized' }}
                                        </span>
                                        <h3 class="font-display h5 fw-semibold text-white mt-2">{{ $product->name }}</h3>
                                        <p class="text-secondary small mb-0">{{ $product->brand }}</p>
                                        <div class="mt-3 mb-3">
                                            @if($product->sale)
                                                <p class="text-gold fs-5 fw-medium mb-0">
                                                    <span class="text-decoration-line-through text-muted-raven small">${{ number_format($product->price, 2) }}</span>
                                                    <span class="ms-2">${{ number_format($product->sale, 2) }}</span>
                                                </p>
                                            @else
                                                <p class="text-gold fs-5 fw-medium mb-0">${{ number_format($product->price, 2) }}</p>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('sunglasses.show', $product) }}" class="btn btn-outline-gold btn-sm rounded-pill flex-grow-1">
                                                View Details
                                            </a>
                                            @auth
                                                <button type="button"
                                                    class="btn btn-gold btn-sm rounded-pill add-to-cart-btn"
                                                    data-product-type="sunglasses"
                                                    data-product-id="{{ $product->id }}"
                                                    @disabled($product->stock < 1)
                                                    title="{{ $product->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}">
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
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <style>
        .border-gold {
            border-color: #d4af37 !important;
        }

        .bg-raven-surface {
            background: rgba(20, 20, 24, 0.55);
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
