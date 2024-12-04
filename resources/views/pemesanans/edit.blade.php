@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Edit Pemesanan</h1>

        <form action="{{ route('pemesanans.update', $pemesanan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User -->
            <div class="form-group mb-3">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $pemesanan->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jadwal -->
            <div class="form-group mb-3">
                <label for="jadwal_id">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-control" required readonly>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ $pemesanan->jadwal_id == $jadwal->id ? 'selected' : '' }}>
                            {{ $jadwal->kereta->nama_kereta }} - {{ $jadwal->waktu_berangkat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nomor Kursi -->
            <div class="form-group mb-3">
                <label for="no_kursi">Nomor Kursi</label>
                <div id="seat-options" class="d-grid" style="grid-template-columns: repeat(16, 1fr); gap: 10px;">
                    @foreach ($availableSeats as $seat)
                        <div class="text-center">
                            <input type="checkbox" name="no_kursi[]" value="{{ $seat }}"
                                id="seat-{{ $seat }}"
                                {{ in_array($seat, $selectedSeats->toArray()) ? 'checked' : '' }} class="form-check-input">
                            <label for="seat-{{ $seat }}" class="d-block mt-1">
                                {{ $seat }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Jumlah Tiket -->
            <div class="form-group mb-3">
                <label for="jumlah_tiket">Jumlah Tiket</label>
                <input type="number" name="jumlah_tiket" id="jumlah_tiket" class="form-control"
                    value="{{ $pemesanan->jumlah_tiket }}" required readonly>
            </div>

            <!-- Total Harga -->
            <div class="form-group mb-3">
                <label for="total_harga">Total Harga</label>
                <input type="number" name="total_harga" id="total_harga" class="form-control"
                    value="{{ $pemesanan->total_harga }}" required readonly>
            </div>

            <!-- Metode Pembayaran -->
            <div class="form-group mb-3">
                <label for="payment_method">Metode Pembayaran</label>
                <input type="text" name="payment_method" id="payment_method" class="form-control"
                    value="{{ $pemesanan->payment_method }}" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('pemesanans.index') }}" class="btn btn-secondary">Kembali</a>

            <!-- Menampilkan pesan error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </form>
    </div>
@endsection
