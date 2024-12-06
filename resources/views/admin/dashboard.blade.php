@extends('layouts.panel')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        .card-header {
            background-color: #b71c1c;
            color: #ffffff;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #1565c0;
            border-color: #1565c0;
        }

        .btn-primary:hover {
            background-color: #0d47a1;
            border-color: #0d47a1;
        }

        .small-box {
            border-radius: 10px;
            padding: 20px;
            color: #fff;
            margin-bottom: 15px;
            position: relative;
        }

        .small-box .inner h3 {
            font-size: 2.5rem;
            display: inline-block;
        }

        .small-box .inner p {
            font-size: 1.1rem;
        }

        .small-box a {
            font-weight: bold;
            color: white;
            bottom: 10px;
            left: 10px;
            font-size: 1.2rem;
        }

        .small-box .bi {
            font-size: 2rem;
            position: absolute;
            right: 5%;
            top: 1%;
            z-index: 0;
            color: #000;
            opacity: 0.5;
        }

        .small-box-footer {
            background-color: rgba(0, 0, 0, .1);
            color: rgba(255, 255, 255, .8);
            display: block;
            padding: 3px 0;
            text-align: center;
            text-decoration: none;
            z-index: 10;
        }

        .small-box-footer:hover {
            background-color: #16202b;
            color: #fff;
        }

        @media (max-width: 768px) {
            .small-box {
                padding: 15px;
            }

            .small-box .inner h3 {
                font-size: 2rem;
            }

            .small-box .inner p {
                font-size: 1rem;
            }

            .col-lg-3,
            .col-md-4,
            .col-6 {
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ Auth::user()->name }}. Berikut adalah ringkasan data sistem.</p>

        <div class="row">
            <!-- Kelola Pemesanan -->
            <div class="col-lg-3 col-md-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $pemesananCount }} </h3>
                        <i class="bi bi-cart-check"></i>
                        <p>Jumlah Pemesanan</p>
                    </div>
                    <a href="{{ route('pemesanans.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>
            <!-- Kelola Pengguna -->
            <div class="col-lg-3 col-md-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $userCount }} </h3>
                        <i class="bi bi-person"></i>
                        <p>Pengguna Terdaftar</p>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>

            <!-- Kelola Jadwal -->
            <div class="col-lg-3 col-md-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $jadwalCount }} </h3>
                        <i class="bi bi-calendar-check"></i>
                        <p>Jadwal Kereta</p>
                    </div>
                    <a href="{{ route('jadwals.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>

            <!-- Kelola Kereta -->
            <div class="col-lg-3 col-md-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $keretaCount }} </h3>
                        <i class="bi bi-train-front"></i>
                        <p>Jumlah Kereta</p>
                    </div>
                    <a href="{{ route('keretas.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>

            <!-- Kelola Stasiun -->
            <div class="col-lg-4 col-md-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $stasiunCount }} </h3>
                        <i class="bi bi-geo-alt"></i>
                        <p>Jumlah Stasiun</p>
                    </div>
                    <a href="{{ route('stasiuns.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>

            <!-- Kelola Rute -->
            <div class="col-lg-4 col-md-4 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>{{ $ruteCount }} </h3>
                        <i class="bi bi-signpost-split"></i>
                        <p>Jumlah Rute</p>
                    </div>
                    <a href="{{ route('rutes.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>

            <!-- Kelola Tiket -->
            <div class="col-lg-4 col-md-4 col-6">
                <div class="small-box bg-dark-subtle">
                    <div class="inner">
                        <h3>{{ $ticketCount }} </h3>
                        <i class="bi bi-ticket-perforated"></i>
                        <p>Jumlah Tiket</p>
                    </div>
                    <a href="{{ route('tikets.index') }}" class="small-box-footer">More info &nbsp; <i
                            class="ea bi-arrow-right-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
