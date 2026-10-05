@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Edit Sunglasses Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card bg-raven-surface border-0 shadow-lg" style="max-width: 600px;">
        <div class="card-body p-5">
            <form id="categoryForm" action="{{ route('admin.sunglasses-categories.update', $sunglassesCategory) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label text-white fw-semibold">Category Name</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $sunglassesCategory->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-white fw-semibold">Current Image</label>
                    @if($sunglassesCategory->image)
                        <div class="mb-3">
                            <img src="{{ $sunglassesCategory->image }}" alt="Category image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label text-white fw-semibold">Change Category Image</label>
                    <input type="file" class="form-control bg-dark border-secondary text-white-50 @error('image') is-invalid @enderror"
                        id="image" name="image" accept="image/*">
                    <small class="text-muted-raven">Upload a new image to replace the current one.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-gold flex-grow-1 fw-bold" id="submitBtn">Update Category</button>
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

    #submitBtn {
        cursor: pointer;
        pointer-events: auto;
        border: none;
        padding: 0.5rem 1rem !important;
        min-height: 44px;
    }

    #submitBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('categoryForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        console.log('Form and submit button found');
        
        submitBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked');
            // Ensure form is submitted
            form.submit();
        });
        
        form.addEventListener('submit', function(e) {
            console.log('Form submit event fired');
            console.log('Form is valid:', form.checkValidity());
        });
    } else {
        console.error('Form or submit button not found');
    }
});
</script>
@endsection
