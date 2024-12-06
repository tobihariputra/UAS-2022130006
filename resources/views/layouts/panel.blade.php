<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.', 'Admin Panel') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'poppins', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar-custom {
            background-color: #c62828;
            background-image: linear-gradient(30deg, rgba(3, 18, 26, 0.325) 50%, rgba(3, 18, 26, 0) 100%);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: #ffffff;
        }

        .sidebar {
            width: 250px;
            background-color: #d32f2f;
            background-image: linear-gradient(30deg, rgba(3, 18, 26, 0.325) 50%, rgba(3, 18, 26, 0) 100%);
            color: #ffffff;
            height: calc(100vh - 56px);
            position: fixed;
            top: 56px;
            left: 0;
            transition: transform 0.3s ease, width 0.3s ease;
            z-index: 1000;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            font-weight: bold;
            transition: background 0.3s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e57373;
            color: #ffffff;
            border-radius: 10px;
        }

        .sidebar .icon {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            margin-top: 56px;
            transition: margin-left 0.3s ease;
            flex-grow: 1;
            padding-bottom: 56px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .main-content .container {
            max-width: calc(100% - 20px);
            padding: 0;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .sidebar .spacer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        footer {
            text-align: center;
            padding: 20px 0;
            font-size: 0.9rem;
            background-color: #f1f1f1;
            width: calc(100% - 250px);
            margin-left: 250px;
            bottom: 0;
            transition: margin-left 0.3s ease, width 0.3s ease;
            border-top: 1px solid #cddfff;
        }

        footer.expanded {
            margin-left: 0;
            width: 100%;
        }

        .navbar-toggler {
            display: block !important;
            border: none;
            outline: none;
            color: white;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.closed {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            footer {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom shadow fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <span class="navbar-brand mb-0 h1 ms-3">Sistem Pemesanan Tiket Kereta</span>
            <span class="navbar-text ms-auto">Halo, {{ Auth::user()->name }}
            </span>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <h1 class="text-center mt-4">Admin Panel</h1>
        <hr style="background-color: #FFF;height: 3px;">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-house-door icon"></i> Dashboard Admin
        </a>
        <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'active' : '' }}">
            <i class="bi bi-people icon"></i> Kelola Pengguna
        </a>
        <a href="{{ route('keretas.index') }}" class="{{ request()->is('keretas*') ? 'active' : '' }}">
            <i class="bi bi-bus-front icon"></i> Kelola Kereta
        </a>
        <a href="{{ route('stasiuns.index') }}" class="{{ request()->is('stasiuns*') ? 'active' : '' }}">
            <i class="bi bi-building icon"></i> Kelola Stasiun
        </a>
        <a href="{{ route('rutes.index') }}" class="{{ request()->is('rutes*') ? 'active' : '' }}">
            <i class="bi bi-map icon"></i> Kelola Rute
        </a>
        <a href="{{ route('jadwals.index') }}" class="{{ request()->is('jadwals*') ? 'active' : '' }}">
            <i class="bi bi-calendar icon"></i> Kelola Jadwal
        </a>
        <a href="{{ route('tikets.index') }}" class="{{ request()->is('tikets*') ? 'active' : '' }}">
            <i class="bi bi-ticket icon"></i> Kelola Tiket
        </a>

        <a href="{{ route('pemesanans.index') }}" class="{{ request()->is('pemesanans*') ? 'active' : '' }}">
            <i class="bi bi-cart icon"></i> Kelola Pemesanan
        </a>
        <div class="spacer"></div>

        <a class="text-decoration-none px-3 py-2 d-block" href="{{ url('/') }}">
            <i class="bi bi-house icon"></i>Dashboard Pengguna</a>
        </a>

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="text-decoration-none px-3 py-2 d-block">
            <i class="bi bi-box-arrow-right icon"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="main-content" id="main-content">
        <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs ?? [] as $breadcrumb)
                        @if (!empty($breadcrumb['url']) && !$loop->last)
                            <li class="breadcrumb-item">
                                <a class="text-decoration-none fw-bold"
                                    href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>

    <footer id="footer" class="footer">
        <div class="credits">
            Built by <a class="text-decoration-none fw-bold" href="https://github.com/tobihariputra">Tobi Hariputra</a>
        </div>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('closed');
            document.getElementById('main-content').classList.toggle('expanded');
            document.getElementById('footer').classList.toggle('expanded');
        }
    </script>
</body>

</html>
