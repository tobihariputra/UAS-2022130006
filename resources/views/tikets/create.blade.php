@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Tiket</h1>

        <form action="{{ route('tikets.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="jadwal_id">Pilih Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}">{{ $jadwal->kereta->nama_kereta }} | {{ $jadwal->rute->nama_rute }} | {{ $jadwal->waktu_berangkat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kelas_tiket">Kelas Tiket</label>
                <select name="kelas_tiket" id="kelas_tiket" class="form-control">
                    <option value="Eksekutif">Eksekutif</option>
                    <option value="Bisnis">Bisnis</option>
                    <option value="Ekonomi" selected>Ekonomi</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="harga">Harga Tiket</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="jumlah">Jumlah Tiket</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" required>
            </div>

            <div class="form-group mb-3">
                <label for="status">Status Tiket</label>
                <select name="status" id="status" class="form-control">
                    <option value="available" selected>Tersedia</option>
                    <option value="unavailable">Tidak Tersedia</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan Tiket</button>
            <a href="{{ route('tikets.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
