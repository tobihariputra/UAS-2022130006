@extends('layouts.app')

@section('content')
    <div class="container shadow p-4"
        style="background-color: #f9f9f9; border-radius: 10px; margin-top: 10%; max-width: 700px;">

        <h1 class="text-center mb-4">Invoice Pemesanan</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Detail Pemesanan</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Kode Pemesanan:</strong> PM-XXXXXXX</li>
                    <li class="list-group-item"><strong>Nama Pengguna:</strong> {{ Auth::user()->name }}</li>
                    <li class="list-group-item"><strong>Jumlah Tiket:</strong> 2 Tiket</li>
                    <li class="list-group-item"><strong>Jadwal:</strong> Kereta X | Rute Y | 12:30 WIB</li>
                    <li class="list-group-item"><strong>Total Harga:</strong> Rp 500.000</li>
                    <li class="list-group-item"><strong>Status Pembayaran:</strong> Belum Dibayar</li>
                </ul>
            </div>
        </div>

        <h4 class="mb-4">Metode Pembayaran</h4>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Pilih Metode Pembayaran</h5>
                <ul class="list-group">
                    <li class="list-group-item">Bank Transfer</li>
                    <li class="list-group-item">Cash</li>
                    <li class="list-group-item">Debit/Credit Card</li>
                    <li class="list-group-item">E-Wallet</li>
                </ul>
            </div>
        </div>

        <h4 class="mb-4">Rincian Pembayaran</h4>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Pembayaran</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Total Harga:</strong> Rp 500.000</li>
                    <li class="list-group-item"><strong>Biaya Lain:</strong> Rp 0</li>
                    <li class="list-group-item"><strong>Total Pembayaran:</strong> Rp 500.000</li>
                </ul>
            </div>
        </div>

    </div>
@endsection
