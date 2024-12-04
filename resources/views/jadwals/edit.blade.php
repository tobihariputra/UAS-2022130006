@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Edit Jadwal Kereta</h1>
        <form action="{{ route('jadwals.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="kereta_id">Nama Kereta</label>
                <select name="kereta_id" id="kereta_id" class="form-control" required>
                    @foreach ($keretas as $kereta)
                        <option value="{{ $kereta->id }}" {{ $jadwal->kereta_id == $kereta->id ? 'selected' : '' }}>
                            {{ $kereta->nama_kereta }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="rute_id">Rute</label>
                <select name="rute_id" id="rute_id" class="form-control" required>
                    @foreach ($rutes as $rute)
                        <option value="{{ $rute->id }}" {{ $jadwal->rute_id == $rute->id ? 'selected' : '' }}>
                            {{ $rute->stasiunAsal->nama_stasiun }} - {{ $rute->stasiunTujuan->nama_stasiun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="waktu_berangkat">Waktu Berangkat</label>
                <input type="datetime-local" name="waktu_berangkat" id="waktu_berangkat" class="form-control"
                    value="{{ $jadwal->waktu_berangkat }}" required>
            </div>
            <div class="form-group mb-3">
                <label for="waktu_tiba">Waktu Tiba</label>
                <input type="datetime-local" name="waktu_tiba" id="waktu_tiba" class="form-control"
                    value="{{ $jadwal->waktu_tiba }}" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
