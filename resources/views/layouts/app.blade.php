<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card {
            transition: all .25s ease;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,.02);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
        }

        h4, h5, h6 {
            letter-spacing: -.3px;
            font-weight: 700;
        }

        .badge {
            border-radius: 999px;
            font-weight: 500;
            padding: 0.5em 1em;
        }

        table th {
            font-size: 12px;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen">
        {{-- Menampilkan Navbar sesuai status login --}}
        @auth
            @if(auth()->user()->role === 'admin')
                @include('layouts.navigation') {{-- Navigasi Admin dari Teman --}}
            @else
                <x-navbar /> {{-- Navbar UMKM buatan Anda --}}
            @endif
        @endauth

        <main class="py-4">
            @if(isset($slot))
                {{ $slot }} {{-- Untuk komponen x-app-layout --}}
            @else
                @yield('content') {{-- Untuk @extends --}}
            @endif
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>