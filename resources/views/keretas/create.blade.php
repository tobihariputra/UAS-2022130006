@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Kereta</h1>
        <form action="{{ route('keretas.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nama_kereta">Nama Kereta</label>
                <input type="text" name="nama_kereta" id="nama_kereta" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="jenis">Jenis Perjalanan</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">Pilih Jenis Perjalanan</option>
                    <option value="Antar Kota">Antar Kota</option>
                    <option value="Komuter">Komuter</option>
                    <option value="Ekspres">Ekspres</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('keretas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
