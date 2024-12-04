@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Edit Kereta</h1>
        <form action="{{ route('keretas.update', $kereta->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nama_kereta">Nama Kereta</label>
                <input type="text" name="nama_kereta" id="nama_kereta" class="form-control" value="{{ $kereta->nama_kereta }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="jenis">Jenis Perjalanan</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="">Pilih Jenis Perjalanan</option>
                    <option value="Antar Kota" {{ $kereta->jenis == 'Antar Kota' ? 'selected' : '' }}>Antar Kota</option>
                    <option value="Komuter" {{ $kereta->jenis == 'Komuter' ? 'selected' : '' }}>Komuter</option>
                    <option value="Ekspres" {{ $kereta->jenis == 'Ekspres' ? 'selected' : '' }}>Ekspres</option>
                    
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('keretas.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
