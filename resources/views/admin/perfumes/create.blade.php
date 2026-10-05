@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Add New Perfume</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-raven-surface border-0 shadow-lg" style="max-width: 600px;">
        <div class="card-body p-5">
            <form action="{{ route('admin.perfumes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="perfumes_category_id" class="form-label text-white fw-semibold">Category</label>
                    <select class="form-select bg-dark border-secondary text-white @error('perfumes_category_id') is-invalid @enderror"
                        id="perfumes_category_id" name="perfumes_category_id" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('perfumes_category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('perfumes_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label text-white fw-semibold">Product Name</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="brand" class="form-label text-white fw-semibold">Brand</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('brand') is-invalid @enderror"
                        id="brand" name="brand" value="{{ old('brand') }}">
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label text-white fw-semibold">Price</label>
                    <input type="number" step="0.01" class="form-control bg-dark border-secondary text-white @error('price') is-invalid @enderror"
                        id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sale" class="form-label text-white fw-semibold">Sale Price (Optional)</label>
                    <input type="number" step="0.01" class="form-control bg-dark border-secondary text-white @error('sale') is-invalid @enderror"
                        id="sale" name="sale" value="{{ old('sale') }}">
                    @error('sale')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="form-label text-white fw-semibold">Stock</label>
                    <input type="number" class="form-control bg-dark border-secondary text-white @error('stock') is-invalid @enderror"
                        id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gender" class="form-label text-white fw-semibold">Gender</label>
                    <select class="form-select bg-dark border-secondary text-white @error('gender') is-invalid @enderror"
                        id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="male" @selected(old('gender') === 'male')>Male</option>
                        <option value="female" @selected(old('gender') === 'female')>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-white fw-semibold">Description</label>
                    <textarea class="form-control bg-dark border-secondary text-white @error('description') is-invalid @enderror"
                        id="description" name="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="images" class="form-label text-white fw-semibold">Product Images (Optional)</label>
                    <input type="file" class="form-control bg-dark border-secondary text-white-50 @error('images.*') is-invalid @enderror"
                        id="images" name="images[]" multiple accept="image/*">
                    <small class="text-muted-raven">You can upload multiple images. If no images are uploaded, a default image will be used.</small>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gold flex-grow-1">Create Perfume</button>
                    <a href="{{ route('admin.perfumes.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-gold {
        background-color: #d4af37;
        color: #09090b;
        border-color: #d4af37;
    }

    .btn-gold:hover {
        background-color: #c9a227;
        color: #09090b;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #1a1a1f;
        border-color: #d4af37;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
</style>
@endsection
