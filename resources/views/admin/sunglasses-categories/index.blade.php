@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white font-display">Sunglasses Categories</h2>
        <a href="{{ route('admin.sunglasses-categories.create') }}" class="btn btn-gold">Add New Category</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card bg-raven-surface border-gold h-100">
                    <div class="card-body">
                        <h5 class="card-title text-gold fw-semibold">{{ $category->name }}</h5>
                        @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img-fluid mb-3" style="max-height: 200px;">
                        @endif
                        <p class="text-muted-raven small mb-3">
                            <strong>Products:</strong> {{ $category->sunglasses_count ?? $category->sunglasses()->count() }}
                        </p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.sunglasses-categories.edit', $category) }}" class="btn btn-sm btn-outline-gold flex-grow-1">Edit</a>
                            <form action="{{ route('admin.sunglasses-categories.destroy', $category) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted-raven">No categories found</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .border-gold {
        border-color: #d4af37 !important;
    }

    .btn-gold {
        background-color: #d4af37;
        color: #09090b;
        border-color: #d4af37;
    }

    .btn-gold:hover {
        background-color: #c9a227;
        color: #09090b;
    }

    .btn-outline-gold {
        color: #d4af37;
        border-color: #d4af37;
    }

    .btn-outline-gold:hover {
        background-color: rgba(212, 175, 55, 0.1);
        color: #d4af37;
    }
</style>
@endsection
