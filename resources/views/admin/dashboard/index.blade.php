@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="text-white font-display display-5">Admin Dashboard</h1>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card bg-raven-surface border-0 text-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-gold">Total Users</h5>
                    <p class="display-6 fw-bold">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-raven-surface border-0 text-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-gold">Perfumes</h5>
                    <p class="display-6 fw-bold">{{ $stats['perfumes'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-raven-surface border-0 text-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-gold">Sunglasses</h5>
                    <p class="display-6 fw-bold">{{ $stats['sunglasses'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-raven-surface border-0 text-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-gold">Categories</h5>
                    <p class="display-6 fw-bold">{{ $stats['perfume_categories'] + $stats['sunglasses_categories'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card bg-raven-surface border-0 text-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-gold">Orders</h5>
                    <p class="display-6 fw-bold">{{ $stats['orders'] }}</p>
                    @if($stats['pending_orders'] > 0)
                        <p class="text-warning small mb-0">{{ $stats['pending_orders'] }} pending</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row g-4">
        <!-- User Management -->
        @if(auth()->user()->role === 'manager')
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">User Management</h5>
                    <p class="text-muted-raven">Add, edit, and manage users</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-gold btn-sm">View Users</a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-gold btn-sm">Add User</a>
                </div>
            </div>
        </div>
        @endif

        <!-- Perfume Categories -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">Perfume Categories</h5>
                    <p class="text-muted-raven">Manage perfume categories</p>
                    <a href="{{ route('admin.perfume-categories.index') }}" class="btn btn-outline-gold btn-sm">View</a>
                    <a href="{{ route('admin.perfume-categories.create') }}" class="btn btn-gold btn-sm">Add</a>
                </div>
            </div>
        </div>

        <!-- Perfumes -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">Perfumes</h5>
                    <p class="text-muted-raven">Manage perfume products</p>
                    <a href="{{ route('admin.perfumes.index') }}" class="btn btn-outline-gold btn-sm">View</a>
                    <a href="{{ route('admin.perfumes.create') }}" class="btn btn-gold btn-sm">Add</a>
                </div>
            </div>
        </div>

        <!-- Sunglasses Categories -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">Sunglasses Categories</h5>
                    <p class="text-muted-raven">Manage sunglasses categories</p>
                    <a href="{{ route('admin.sunglasses-categories.index') }}" class="btn btn-outline-gold btn-sm">View</a>
                    <a href="{{ route('admin.sunglasses-categories.create') }}" class="btn btn-gold btn-sm">Add</a>
                </div>
            </div>
        </div>

        <!-- Sunglasses -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">Sunglasses</h5>
                    <p class="text-muted-raven">Manage sunglasses products</p>
                    <a href="{{ route('admin.sunglasses.index') }}" class="btn btn-outline-gold btn-sm">View</a>
                    <a href="{{ route('admin.sunglasses.create') }}" class="btn btn-gold btn-sm">Add</a>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="card-title text-gold">Orders</h5>
                    <p class="text-muted-raven">Review customer checkout requests</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-gold btn-sm">View Orders</a>
                </div>
            </div>
        </div>
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
        border-color: #c9a227;
        color: #09090b;
    }

    .btn-outline-gold {
        color: #d4af37;
        border-color: #d4af37;
    }

    .btn-outline-gold:hover {
        background-color: rgba(212, 175, 55, 0.1);
        border-color: #d4af37;
        color: #d4af37;
    }
</style>
@endsection
