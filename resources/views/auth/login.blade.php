<x-guest-layout>
    <title>Login - Kumparan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f4f7fe !important; }
        
        .login-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            max-width: 380px;
            width: 100%;
            border: none;
        }

        /* Style untuk Logo Teks */
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #333;
            text-decoration: none;
            display: block;
        }

        .brand-icon {
            font-size: 1.5rem;
            color: #0d6efd;
            background: #e7f1ff;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            margin: 0 auto 15px;
        }

        .form-label { font-weight: 600; color: #444; margin-bottom: 8px; }
        .form-control { 
            border-radius: 10px; 
            border: 1px solid #dce1e7; 
            padding: 10px 15px; 
        }
        .form-control:focus { 
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); 
            border-color: #0d6efd; 
        }
        .btn-login {
            background-color: #0d6efd;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
    </style>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-4">
        <div class="login-card p-4 p-md-5">
            
            <div class="text-center mb-4">
                <a class="brand-logo" href="/">
                    KUMPARAN<span class="text-primary">.</span>
                </a>
            </div>

            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h4 class="fw-bold mb-1">Selamat Datang</h4>
                <p class="text-muted small">Masuk ke akun Kumparan Digital Anda</p>
            </div>

            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small fw-semibold" href="{{ route('password.request') }}">
                                Lupa?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        required placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="form-check mb-4">
                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label text-muted small">
                        Ingat saya
                    </label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-login text-white shadow-sm">
                        Masuk Sekarang
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted">Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-primary">Daftar Gratis</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>