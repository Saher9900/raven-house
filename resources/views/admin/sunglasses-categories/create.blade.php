@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Add New Sunglasses Category</h2>

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
            <form action="{{ route('admin.sunglasses-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label text-white fw-semibold">Category Name</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label text-white fw-semibold">Category Image (Optional)</label>
                    <input type="file" class="form-control bg-dark border-secondary text-white-50 @error('image') is-invalid @enderror"
                        id="image" name="image" accept="image/*">
                    <small class="text-muted-raven">If no image is uploaded, a default image will be used.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gold flex-grow-1">Create Category</button>
                    <a href="{{ route('admin.sunglasses-categories.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancel</a>
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

    .form-control:focus {
        background-color: #1a1a1f;
        border-color: #d4af37;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }
</style>
@endsection
