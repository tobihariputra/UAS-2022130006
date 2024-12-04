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
    </style>

    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, {{ Auth::user()->name }}. Berikut adalah ringkasan data sistem.</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Pengguna</div>
                    <div class="card-body">
                        <p>Jumlah Pengguna: {{ $userCount }}</p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Lihat Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Kereta</div>
                    <div class="card-body">
                        <p>Jumlah Kereta: {{ $keretaCount }}</p>
                        <a href="{{ route('keretas.index') }}" class="btn btn-primary">Lihat Kereta</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Stasiun</div>
                    <div class="card-body">
                        <p>Jumlah Stasiun: {{ $stasiunCount }}</p>
                        <a href="{{ route('stasiuns.index') }}" class="btn btn-primary">Lihat Stasiun</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Rute</div>
                    <div class="card-body">
                        <p>Jumlah Rute: {{ $ruteCount }}</p>
                        <a href="{{ route('rutes.index') }}" class="btn btn-primary">Lihat Rute</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Jadwal</div>
                    <div class="card-body">
                        <p>Jumlah Jadwal Kereta: {{ $jadwalCount }}</p>
                        <a href="{{ route('jadwals.index') }}" class="btn btn-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Tiket</div>
                    <div class="card-body">
                        <p>Jumlah Tiket: {{ $ticketCount }}</p>
                        <a href="{{ route('tikets.index') }}" class="btn btn-primary">Lihat Tiket</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Kelola Pemesanan</div>
                    <div class="card-body">
                        <p>Jumlah Pemesanan: {{ $pemesananCount }}</p>
                        <a href="{{ route('pemesanans.index') }}" class="btn btn-primary">Lihat Pemesanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
