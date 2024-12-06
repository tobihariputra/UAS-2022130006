@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Edit Tiket</h1>

        <form action="{{ route('tikets.update', $tiket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Pilih Jadwal -->
            <div class="form-group mb-3">
                <label for="jadwal_id">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-control" required disabled>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ $tiket->jadwal_id == $jadwal->id ? 'selected' : '' }}>
                            {{ $jadwal->kereta->nama_kereta }} - {{ $jadwal->waktu_berangkat }}
                        </option>
                    @endforeach
                </select>
                <!-- Hidden input for jadwal_id -->
                <input type="hidden" name="jadwal_id" value="{{ $tiket->jadwal_id }}">
            </div>

            <!-- Kode Tiket -->
            <div class="form-group mb-3">
                <label for="kode_tiket">Kode Tiket</label>
                <input type="text" name="kode_tiket" id="kode_tiket" class="form-control"
                    value="{{ $tiket->kode_tiket }}" readonly style="background-color: #f0f0f0;">
            </div>

            <!-- Pilih Kelas Tiket -->
            <div class="form-group mb-3">
                <label for="kelas_tiket">Kelas Tiket</label>
                <select name="kelas_tiket" id="kelas_tiket" class="form-control" required>
                    <option value="Eksekutif" {{ $tiket->kelas_tiket == 'Eksekutif' ? 'selected' : '' }}>Eksekutif</option>
                    <option value="Bisnis" {{ $tiket->kelas_tiket == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                    <option value="Ekonomi" {{ $tiket->kelas_tiket == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                </select>
            </div>

            <!-- Harga Tiket -->
            <div class="form-group mb-3">
                <label for="harga">Harga Tiket</label>
                <input type="number" name="harga" id="harga" class="form-control" value="{{ $tiket->harga }}"
                    required>
            </div>

            <!-- Status Tiket -->
            <div class="form-group mb-3">
                <label for="status">Status Tiket</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="available" {{ $tiket->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="unavailable" {{ $tiket->status == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia
                    </option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('tikets.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
