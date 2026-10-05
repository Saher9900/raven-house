@extends('website.layout.main')
@section('content')
    <main class="product-detail-page">
        <section class="pb-5">
            <div class="container">
                <a href="{{ route('perfumes.page') }}" class="btn btn-outline-gold rounded-pill px-4 mb-4">
                    ← Back to Perfumes
                </a>

                <div class="row g-5">
                    <!-- Product Images -->
                    <div class="col-lg-5">
                        <div class="product-visual product-detail-visual d-flex align-items-center justify-content-center rounded-4 overflow-hidden mb-4"
                            style="background: linear-gradient(to bottom, rgba(69,26,3,0.4), #09090b);">
                            @if($perfume->images->first())
                                <img src="{{ asset($perfume->images->first()->image_path) }}" alt="{{ $perfume->name }}"
                                    class="w-100 h-100 product-detail-image">
                            @else
                                <div class="perfume-bottle"></div>
                            @endif
                        </div>

                        @if($perfume->images->count() > 1)
                            <div class="row g-3">
                                @foreach($perfume->images as $image)
                                    <div class="col-4">
                                        <div class="rounded-3 overflow-hidden cursor-pointer" style="height: 100px; background: rgba(20,20,24,0.8);">
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $perfume->name }}"
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
                            {{ $perfume->category?->name ?? 'Uncategorized' }}
                        </span>

                        <h1 class="font-display display-5 fw-bold text-white mt-3 mb-2">{{ $perfume->name }}</h1>
                        <p class="text-secondary fs-5 mb-4">{{ $perfume->brand }}</p>

                        <!-- Price -->
                        <div class="mb-4">
                            @if($perfume->sale)
                                <p class="text-gold fs-3 fw-bold mb-0">
                                    <span class="text-decoration-line-through text-muted-raven">${{ number_format($perfume->price, 2) }}</span>
                                    <span class="ms-3">${{ number_format($perfume->sale, 2) }}</span>
                                </p>
                            @else
                                <p class="text-gold fs-3 fw-bold mb-0">${{ number_format($perfume->price, 2) }}</p>
                            @endif
                        </div>

                        <!-- Product Info Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="card bg-raven-surface border-gold rounded-3">
                                    <div class="card-body">
                                        <p class="text-gold small text-uppercase mb-2">Gender</p>
                                        <p class="text-white fw-semibold mb-0">{{ ucfirst($perfume->gender) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-raven-surface border-gold rounded-3">
                                    <div class="card-body">
                                        <p class="text-gold small text-uppercase mb-2">Stock</p>
                                        <p class="text-white fw-semibold mb-0">
                                            @if($perfume->stock > 0)
                                                {{ $perfume->stock }} Available
                                            @else
                                                <span class="text-danger">Out of Stock</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($perfume->description)
                            <div class="mb-4">
                                <h5 class="text-gold mb-3">Description</h5>
                                <p class="text-muted-raven">{{ $perfume->description }}</p>
                            </div>
                        @endif

                        <!-- Add to Cart -->
                        @auth
                            <button type="button"
                                class="btn btn-gold btn-lg rounded-pill px-5 w-100 add-to-cart-btn"
                                data-product-type="perfume"
                                data-product-id="{{ $perfume->id }}"
                                @disabled($perfume->stock < 1)>
                                <span class="fs-5">
                                    {{ $perfume->stock < 1 ? 'Out of Stock' : 'Add to Cart' }}
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
                        <p class="section-eyebrow mb-3">Similar Scents</p>
                        <h2 class="font-display section-title fw-semibold text-white">Related Perfumes</h2>
                        <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                    </div>

                    <div class="row g-4">
                        @foreach($relatedProducts as $product)
                            <div class="col-sm-6 col-lg-4">
                                <article class="product-card rounded-4 overflow-hidden h-100">
                                    <div class="product-visual d-flex align-items-center justify-content-center"
                                        style="background: linear-gradient(to bottom, rgba(69,26,3,0.4), #09090b);">
                                        @if($product->images->first())
                                            <img src="{{ asset($product->images->first()->image_path) }}" alt="{{ $product->name }}"
                                                class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="perfume-bottle"></div>
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
                                            <a href="{{ route('perfumes.show', $product) }}" class="btn btn-outline-gold btn-sm rounded-pill flex-grow-1">
                                                View Details
                                            </a>
                                            @auth
                                                <button type="button"
                                                    class="btn btn-gold btn-sm rounded-pill add-to-cart-btn"
                                                    data-product-type="perfume"
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
