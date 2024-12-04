@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Jadwal Kereta</h1>
        <form action="{{ route('jadwals.store') }}" method="POST" id="jadwalForm">
            @csrf
            <div class="form-group mb-3">
                <label for="kereta_id">Nama Kereta</label>
                <select name="kereta_id" id="kereta_id" class="form-control" required>
                    <option value="">Pilih Kereta</option>
                    @foreach ($keretas as $kereta)
                        <option value="{{ $kereta->id }}">{{ $kereta->nama_kereta }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="rute_id">Rute</label>
                <select name="rute_id" id="rute_id" class="form-control" required>
                    <option value="">Pilih Rute</option>
                    @foreach ($rutes as $rute)
                        <option value="{{ $rute->id }}">{{ $rute->nama_rute }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="waktu_berangkat">Waktu Berangkat</label>
                <input type="datetime-local" name="waktu_berangkat" id="waktu_berangkat" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="waktu_tiba">Waktu Tiba</label>
                <input type="datetime-local" name="waktu_tiba" id="waktu_tiba" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Inisialisasi Flatpickr dengan format waktu 24 jam
        flatpickr("#waktu_berangkat", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

        flatpickr("#waktu_tiba", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    </script>
    <script>
        // Validasi waktu saat form disubmit
        document.getElementById('jadwalForm').addEventListener('submit', function(event) {
            const waktuBerangkat = new Date(document.getElementById('waktu_berangkat').value);
            const waktuTiba = new Date(document.getElementById('waktu_tiba').value);

            // Validasi apakah waktu berangkat dan tiba diisi
            if (!waktuBerangkat || !waktuTiba) {
                alert("Waktu berangkat dan waktu tiba harus diisi.");
                event.preventDefault();
                return;
            }

            // Validasi apakah waktu tiba lebih besar dari waktu berangkat
            if (waktuTiba <= waktuBerangkat) {
                alert("Waktu tiba tidak boleh lebih awal atau sama dengan waktu berangkat.");
                event.preventDefault(); // Cegah form disubmit
                return;
            }
        });
    </script>
@endsection
