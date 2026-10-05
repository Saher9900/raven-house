<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raven House - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --raven-gold: #d4af37;
            --raven-dark: #09090b;
            --raven-surface: #1a1a1f;
            --muted-raven: #5a5a64;
        }

        body {
            background-color: var(--raven-dark);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background-color: var(--raven-surface);
            border: none;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.15);
            max-width: 450px;
            width: 100%;
            border-radius: 10px;
        }

        .login-card .card-body {
            padding: 50px;
        }

        .login-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 40px;
            color: white;
            letter-spacing: 1px;
        }

        .form-label {
            color: white;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .form-control {
            background-color: #0f0f14;
            border: 1px solid #333;
            color: white;
            padding: 12px 15px;
            border-radius: 5px;
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-control:focus {
            background-color: #0f0f14;
            border-color: var(--raven-gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 0.875rem;
            display: block;
            margin-top: 5px;
        }

        .btn-login {
            background-color: var(--raven-gold);
            color: var(--raven-dark);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 5px;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #c9a227;
            color: var(--raven-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .alert {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #ff6b6b;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            margin-bottom: 5px;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            color: var(--raven-gold);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #c9a227;
        }

        .divider {
            background-color: #333;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-body">
                <h1 class="login-title">Raven House</h1>

                @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login w-100">Login</button>
                </form>

                <hr class="divider">

                <div class="back-link">
                    <a href="{{ route('perfumes.page') }}">← Back to Website</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
