<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Kumparan</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f4f7fe !important; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .login-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            max-width: 450px;
            width: 100%;
            border: none;
        }

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
        
        .form-control, .form-select { 
            border-radius: 10px; 
            border: 1px solid #dce1e7; 
            padding: 10px 15px; 
        }

        .form-control:focus, .form-select:focus { 
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1); 
            border-color: #0d6efd; 
            outline: none;
        }

        .btn-register {
            background-color: #0d6efd;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            transition: 0.3s;
            color: white;
            width: 100%;
        }

        .btn-register:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="login-card p-4 p-md-5">
            
            <div class="text-center mb-4">
                <a class="brand-logo" href="/">
                    KUMPARAN<span class="text-primary">.</span>
                </a>
            </div>

            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h4 class="fw-bold mb-1">Buat Akun Baru</h4>
                <p class="text-muted small">Gabung dengan ekosistem Kumparan Digital</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input id="name" type="text" name="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}" required autofocus placeholder="Masukkan nama Anda">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        value="{{ old('email') }}" required placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Daftar Sebagai</label>
                    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="umkm" {{ old('role') == 'umkm' ? 'selected' : '' }}>Pelaku UMKM</option>
                        <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra Usaha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        required placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                        class="form-control" required placeholder="Ulangi password">
                </div>

                <button type="submit" class="btn-register">
                    Daftar Sekarang
                </button>

                <div class="text-center mt-4">
                    <p class="small text-muted">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none text-primary">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>