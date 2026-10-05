@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Edit Perfume</h2>

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
            <form id="perfumeForm" action="{{ route('admin.perfumes.update', $perfume) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="perfumes_category_id" class="form-label text-white fw-semibold">Category</label>
                    <select class="form-select bg-dark border-secondary text-white @error('perfumes_category_id') is-invalid @enderror"
                        id="perfumes_category_id" name="perfumes_category_id" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('perfumes_category_id', $perfume->perfumes_category_id) == $category->id)>
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
                        id="name" name="name" value="{{ old('name', $perfume->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="brand" class="form-label text-white fw-semibold">Brand</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('brand') is-invalid @enderror"
                        id="brand" name="brand" value="{{ old('brand', $perfume->brand) }}">
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label text-white fw-semibold">Price</label>
                    <input type="number" step="0.01" class="form-control bg-dark border-secondary text-white @error('price') is-invalid @enderror"
                        id="price" name="price" value="{{ old('price', $perfume->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="sale" class="form-label text-white fw-semibold">Sale Price (Optional)</label>
                    <input type="number" step="0.01" class="form-control bg-dark border-secondary text-white @error('sale') is-invalid @enderror"
                        id="sale" name="sale" value="{{ old('sale', $perfume->sale) }}">
                    @error('sale')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="stock" class="form-label text-white fw-semibold">Stock</label>
                    <input type="number" class="form-control bg-dark border-secondary text-white @error('stock') is-invalid @enderror"
                        id="stock" name="stock" value="{{ old('stock', $perfume->stock) }}" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gender" class="form-label text-white fw-semibold">Gender</label>
                    <select class="form-select bg-dark border-secondary text-white @error('gender') is-invalid @enderror"
                        id="gender" name="gender" required>
                        <option value="male" @selected(old('gender', $perfume->gender) === 'male')>Male</option>
                        <option value="female" @selected(old('gender', $perfume->gender) === 'female')>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label text-white fw-semibold">Description</label>
                    <textarea class="form-control bg-dark border-secondary text-white @error('description') is-invalid @enderror"
                        id="description" name="description" rows="4">{{ old('description', $perfume->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-white fw-semibold">Current Images</label>
                    <div class="row g-2">
                        @forelse($perfume->images as $image)
                            <div class="col-md-6">
                                <div class="position-relative">
                                    <img src="{{ $image->image_path }}" alt="Product image" class="img-fluid rounded" style="max-height: 150px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 5px; right: 5px;"
                                        onclick="deleteImage({{ $image->id }}, {{ $perfume->id }})">Delete</button>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted-raven">No images uploaded yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4">
                    <label for="images" class="form-label text-white fw-semibold">Add More Images</label>
                    <input type="file" class="form-control bg-dark border-secondary text-white-50 @error('images.*') is-invalid @enderror"
                        id="images" name="images[]" multiple accept="image/*">
                    <small class="text-muted-raven">You can upload additional images.</small>
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-gold flex-grow-1 fw-bold" id="submitBtn">Update Perfume</button>
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
    const form = document.getElementById('perfumeForm');
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

function deleteImage(imageId, perfumeId) {
    if (!confirm('Delete this image?')) {
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch(`/admin/images/${imageId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _method: 'DELETE'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success || data.redirect) {
            window.location.href = data.redirect || `/admin/perfumes/${perfumeId}/edit`;
        } else {
            alert('Failed to delete image');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete image');
    });
}
</script>
@endsection
