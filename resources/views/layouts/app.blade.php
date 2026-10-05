<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Raven House Admin - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --raven-gold: #d4af37;
            --raven-dark: #09090b;
            --raven-surface: #1a1a1f;
            --muted-raven: #5a5a64;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--raven-dark);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: var(--raven-surface);
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--raven-gold) !important;
            letter-spacing: 1px;
        }

        .nav-link {
            color: #aaa !important;
            margin-left: 20px;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--raven-gold) !important;
        }

        .nav-link.active {
            color: var(--raven-gold) !important;
            border-bottom: 2px solid var(--raven-gold);
        }

        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .main-container {
            min-height: calc(100vh - 60px);
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .page-header {
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
            padding-bottom: 15px;
        }

        .btn-gold {
            background-color: var(--raven-gold);
            color: var(--raven-dark);
            border-color: var(--raven-gold);
            font-weight: 600;
        }

        .btn-gold:hover {
            background-color: #c9a227;
            color: var(--raven-dark);
            border-color: #c9a227;
        }

        .card {
            background-color: var(--raven-surface);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 8px;
        }

        .form-control,
        .form-select {
            background-color: #0f0f14;
            border: 1px solid #333;
            color: white;
            padding: 10px 12px;
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #0f0f14;
            border-color: var(--raven-gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .invalid-feedback {
            color: #ff6b6b;
            display: block;
            margin-top: 5px;
        }

        .alert {
            border-radius: 5px;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #ff6b6b;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid #28a745;
            color: #70ee70;
        }

        .table {
            color: #ddd;
            border-color: #333;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(212, 175, 55, 0.05);
        }

        .table-striped > tbody > tr:hover {
            background-color: rgba(212, 175, 55, 0.1);
        }

        .table thead {
            background-color: rgba(212, 175, 55, 0.15);
            border-bottom: 2px solid var(--raven-gold);
        }

        .text-gold {
            color: var(--raven-gold);
        }

        .text-muted-raven {
            color: var(--muted-raven);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-admin {
            background-color: rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
        }

        .badge-manager {
            background-color: rgba(255, 193, 7, 0.3);
            color: #ffc107;
        }

        .badge-user {
            background-color: rgba(23, 162, 184, 0.3);
            color: #17a2b8;
        }

        footer {
            background-color: var(--raven-surface);
            border-top: 1px solid rgba(212, 175, 55, 0.1);
            padding: 20px 0;
            text-align: center;
            color: var(--muted-raven);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Raven House Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                    </li>
                    @if(auth()->user()->role === 'manager')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.perfumes.index') }}">Perfumes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.perfume-categories.index') }}">Perfume Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sunglasses.index') }}">Sunglasses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sunglasses-categories.index') }}">Sunglasses Categories</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Raven House. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
