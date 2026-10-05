@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-white font-display mb-4">Edit User</h2>

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
            <form id="userForm" action="{{ route('admin.users.update', $user) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label text-white fw-semibold">Name</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label text-white fw-semibold">Email</label>
                    <input type="email" class="form-control bg-dark border-secondary text-white @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label text-white fw-semibold">Role</label>
                    <select class="form-select bg-dark border-secondary text-white @error('role') is-invalid @enderror"
                        id="role" name="role" required>
                        <option value="normal_user" @selected(old('role', $user->role) === 'normal_user')>Normal User</option>
                        <option value="manager" @selected(old('role', $user->role) === 'manager')>Manager</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn btn-gold flex-grow-1 fw-bold" id="submitBtn">Update User</button>
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
    const form = document.getElementById('userForm');
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
