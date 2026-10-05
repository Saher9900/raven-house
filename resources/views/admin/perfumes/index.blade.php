@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white font-display">Perfume Management</h2>
        <a href="{{ route('admin.perfumes.create') }}" class="btn btn-gold">Add New Perfume</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="table-gold">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Gender</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perfumes as $perfume)
                    <tr>
                        <td>{{ $perfume->id }}</td>
                        <td class="text-white fw-semibold">{{ $perfume->name }}</td>
                        <td>{{ $perfume->category->name ?? 'N/A' }}</td>
                        <td>{{ $perfume->brand ?? '-' }}</td>
                        <td class="text-gold fw-semibold">${{ number_format($perfume->price, 2) }}</td>
                        <td>{{ $perfume->stock }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($perfume->gender) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.perfumes.edit', $perfume) }}" class="btn btn-sm btn-outline-gold">Edit</a>
                            <form action="{{ route('admin.perfumes.destroy', $perfume) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted-raven py-4">No perfumes found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $perfumes->links() }}
    </div>
</div>

<style>
    .table-gold thead {
        background-color: #d4af37;
        color: #09090b;
    }

    .table-dark tbody tr:hover {
        background-color: rgba(212, 175, 55, 0.1);
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
