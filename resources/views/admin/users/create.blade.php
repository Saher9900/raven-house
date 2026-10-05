@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Add New User</h2>

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
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label text-white fw-semibold">Name</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label text-white fw-semibold">Email</label>
                    <input type="email" class="form-control bg-dark border-secondary text-white @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-white fw-semibold">Password</label>
                    <input type="password" class="form-control bg-dark border-secondary text-white @error('password') is-invalid @enderror"
                        id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-white fw-semibold">Confirm Password</label>
                    <input type="password" class="form-control bg-dark border-secondary text-white"
                        id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label text-white fw-semibold">Role</label>
                    <select class="form-select bg-dark border-secondary text-white @error('role') is-invalid @enderror"
                        id="role" name="role" required>
                        <option value="">Select a role</option>
                        <option value="normal_user" @selected(old('role') === 'normal_user')>Normal User</option>
                        <option value="manager" @selected(old('role') === 'manager')>Manager</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-gold flex-grow-1">Create User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary flex-grow-1">Cancel</a>
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
