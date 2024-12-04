@extends('layouts.app')

@section('content')
    <div class="container shadow p-4"
        style="background-color: #f9f9f9; border-radius: 10px; margin-top: 10%; max-width: 600px;">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-center mb-4">Halaman Pembayaran</h1>

        <form action="{{ route('pemesanans.users.invoice') }}" method="GET">
            @csrf

            <div class="form-group mb-3">
                <label for="payment_method">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash">Cash</option>
                    <option value="Debit/Credit Card">Debit/Credit Card</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success btn-block mt-3">Konfirmasi Pembayaran</button>
        </form>

    </div>
@endsection
