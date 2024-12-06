<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.', 'Sistem Pemesanan Tiket Kereta') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Nunito', sans-serif;
            scroll-behavior: smooth;
        }

        main {
            flex: 1;
            margin-bottom: 100px;
            padding: 0;
            box-sizing: border-box;
        }

        .navbar-custom {
            background-color: transparent;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            position: absolute;
            z-index: 1000;
            width: 100%;
            height: 75px;
            box-sizing: border-box;
            align-items: stretch;
            justify-content: center;
            display: flex;
            border-bottom: 4px solid transparent;
        }

        .navbar-custom.scrolled {
            position: sticky;
            background-image: linear-gradient(30deg, rgba(3, 18, 26, 0.325) 50%, rgba(3, 18, 26, 0) 100%);
            background-color: #e63946;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff !important;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #e63946 !important;
            background-color: #ffffff !important;
            border-radius: 5px;
            padding: 10px 10px;
        }

        .navbar-toggler-icon {
            border-radius: 3px;
        }

        .navbar-login {
            background-color: #e63946 !important;
            border-bottom: 4px solid #e63946;
        }

        .navbar-auth {
            background-color: #e63946 !important;
            border-bottom: 4px solid #e63946;
        }

        footer {
            background-image: linear-gradient(30deg, rgba(3, 18, 26, 0.325) 50%, rgba(3, 18, 26, 0) 100%);
            background-color: #e63946;
            color: #ffffff;
            padding: 20px 0;
            text-align: left;
            font-size: 14px;
            border-top: 5px solid #e63946;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            color: #ffe5e5;
            text-decoration: underline;
        }

        .navbar-custom .nav-link {
            font-size: 16px;
            transition: color 0.3s ease;
        }

        @media (max-width: 768px) {
            .navbar-custom .nav-link {
                font-size: 14px;
            }

            footer {
                font-size: 12px;
            }

            .card {
                width: 100%;
                margin-top: 100px;
            }
        }

        .navbar-nav .nav-item i {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav
            class="navbar navbar-expand-md navbar-custom {{ Request::routeIs('login', 'register', 'password.request', 'password.email', 'password.reset', 'password.confirm', 'password.update', 'password.change', 'privacy.policy', 'panduan.pemesanan', 'pemesanans.users.create', 'pemesanans.users.payment', 'pemesanans.users.invoice') ? 'navbar-login' : '' }} sticky-top py-5 shadow mb-5">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    {{ config('app.', 'Sistem Pemesanan Tiket Kereta') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pemesanans.users.create') }}">Pesan Tiket</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Kontak Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('privacy.policy') }}">Privacy Policy</a>
                        </li>
                        <li class="nav-item"></li>
                        <a class="nav-link" href="{{ route('panduan.pemesanan') }}">Panduan
                            Pemesanan</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-person-circle"></i>{{ __('Login') }}
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus-fill"></i>{{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer id="footer" class="footer">
            <div class="container py-5">
                <div class="row d-flex">
                    <div class="col-12 col-md-3 mb-4">
                        <h5 class="fw-bold">SISTEM PEMESANAN TIKET KERETA</h5>
                        <hr style="background-color: #FFF;height: 5px;">
                        <p class="text-white text-left mt-4">
                            Layanan booking tiket kereta api online. Beli tiket kereta jadi cepat, nyaman dan mudah.
                            Dibuat oleh Tobi Hariputra
                        </p>
                    </div>

                    <div class="col-12 col-md-3 mb-4">
                        <h5 class="fw-bold">MENU</h5>
                        <hr style="background-color: #FFF;height: 5px;">
                        <ul class="list-unstyled text-small mt-4">
                            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
                            <li><a class="text-white" href="{{ route('pemesanans.users.create') }}"
                                    target="_blank">Pesan Tiket</a>
                            </li>
                            <li><a class="text-white" href="{{ route('panduan.pemesanan') }}" target="_blank">Panduan
                                    Pemesanan</a></li>

                            </li>
                            <li><a class="text-white" href="{{ route('privacy.policy') }}" target="_blank">Kebijakan
                                    dan Privasi</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h5 class="fw-bold">HUBUNGI KAMI</h5>
                        <hr style="background-color: #FFF;height: 5px;">
                        <p class="text-left mt-4">
                            <b>Telepon :</b> 0889-888-888(EA)<br>
                            Layanan pelanggan tersedia pukul 08:00-21:00<br>
                            <b>Email:</b> support@likmi.com
                        </p>
                    </div>
                    <div class="col-12 col-md-3 mb-4">
                        <h5 class="fw-bold">IKUTI KAMI</h5>
                        <hr style="background-color: #FFF;height: 5px;">
                        <ul class="list-unstyled d-flex social icon_margin_right mt-4">
                            <li style="margin-right: 20px;">
                                <a class="bi bi-facebook" href="https://www.facebook.com/jileyz/" target="_blank">
                                </a>
                            </li>
                            <li style="margin-right: 20px;">
                                <a class="bi bi-instagram" href="https://www.instagram.com/tobihariputra/"
                                    target="_blank">
                                </a>
                            </li>
                            <li style=""></li>
                            <a class="bi bi-whatsapp" href="https://wa.me/088988888888" target="_blank">
                            </a>
                            </li>
                        </ul>
                        <br>
                        <h5 class="fw-bold">METODE PEMBAYARAN</h5>
                        <img src="{{ asset('images/payment logo.png') }}" width="300" height="135">
                    </div>
                </div>
            </div>
            <hr style="background-color: #FFF;height: 3px;">

            <div id="copyright">
                <div class="container text-muted fw-bold" align="center"
                    style=" padding: 10px; color: white ! important; font-weight: 500 ! important;">
                    Copyright © 2024 Sistem Pemesanan Tiket Kereta, All rights reserved. <br>Built by <a
                        href="https://github.com/tobihariputra">Tobi Hariputra</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

</body>

</html>
