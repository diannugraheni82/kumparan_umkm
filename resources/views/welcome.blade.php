    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kumparan Digital</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
        <style>
            .text-primary {
                color: #0052B0 !important;
            }

            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden; 
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            .hero-section {
                background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.3)), 
                                url('{{ asset("images/background_welcome.jpg") }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                height: 100vh;
                width: 100vw;
                display: flex;
                align-items: center;
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(5px);
                padding: 40px;
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body>

        <section class="hero-section">
            <div class="container">
                <div class="row justify-content-end w-100">
                    <div class="col-md-8 col-lg-8 text-end d-flex flex-column align-items-end"> 
                        <h1 class="display-3 fw-bold mb-3 text-primary">Kumparan Digital</h1>
                        
                        <p class="lead fs-4 mb-5 text-white">
                            Solusi cerdas kolaborasi UMKM digital <br> untuk pertumbuhan ekonomi yang lebih masif.
                        </p>
                        
                        </div>                            
                            <div class="d-flex justify-content-end gap-3">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">Log in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Register</a>
                                        @endif
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>