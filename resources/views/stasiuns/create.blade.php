@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Stasiun</h1>
        <form action="{{ route('stasiuns.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nama_stasiun">Nama Stasiun</label>
                <input type="text" name="nama_stasiun" id="nama_stasiun" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="kota">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('stasiuns.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
