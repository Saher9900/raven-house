@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white font-display">Featured Products</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-gold">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card bg-raven-surface border-gold mb-4">
        <div class="card-body">
            <h3 class="h5 text-gold mb-3">Add a product to the homepage</h3>
            <form action="{{ route('admin.featured-products.store') }}" method="POST" class="row g-3 align-items-end">
                @csrf
                <div class="col-md-9">
                    <label for="featured-product" class="form-label text-white">Choose an existing product</label>
                    <select id="featured-product" name="product" class="form-select" required>
                        <option value="">Select a product</option>
                        @if ($availablePerfumes->isNotEmpty())
                            <optgroup label="Perfumes">
                                @foreach ($availablePerfumes as $perfume)
                                    <option value="perfume:{{ $perfume->id }}" @selected(old('product') === "perfume:{$perfume->id}")>
                                        {{ $perfume->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if ($availableSunglasses->isNotEmpty())
                            <optgroup label="Sunglasses">
                                @foreach ($availableSunglasses as $sunglasses)
                                    <option value="sunglasses:{{ $sunglasses->id }}" @selected(old('product') === "sunglasses:{$sunglasses->id}")>
                                        {{ $sunglasses->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    @error('product')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-gold w-100">Add to featured</button>
                </div>
            </form>
        </div>
    </div>

    <h3 class="h5 text-white mb-3">Currently featured</h3>
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle">
            <thead class="table-gold">
                <tr>
                    <th>Order</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Reorder</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($featuredProducts as $featuredProduct)
                    @php
                        $product = $featuredProduct->perfume ?? $featuredProduct->sunglasses;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-white fw-semibold">{{ $product->name }}</td>
                        <td>{{ $featuredProduct->perfume ? 'Perfume' : 'Sunglasses' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                @unless ($loop->first)
                                    <form action="{{ route('admin.featured-products.move', $featuredProduct) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" class="btn btn-sm btn-outline-gold"
                                            aria-label="Move {{ $product->name }} up">↑</button>
                                    </form>
                                @endunless
                                @unless ($loop->last)
                                    <form action="{{ route('admin.featured-products.move', $featuredProduct) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" class="btn btn-sm btn-outline-gold"
                                            aria-label="Move {{ $product->name }} down">↓</button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.featured-products.destroy', $featuredProduct) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted-raven py-4">No featured products selected yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
