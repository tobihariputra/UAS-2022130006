@extends('layouts.panel')

@section('title', 'Tambah Rute')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Rute</h1>
        <form action="{{ route('rutes.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nama_rute">Nama Rute</label>
                <input type="text" name="nama_rute" id="nama_rute" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="stasiun_asal">Stasiun Asal</label>
                <select name="stasiun_asal_id" id="stasiun_asal" class="form-control" required>
                    <option value="" disabled selected>Pilih Stasiun Asal</option>
                    @foreach ($stasiuns as $stasiun)
                        <option value="{{ $stasiun->id }}">{{ $stasiun->nama_stasiun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="stasiun_tujuan">Stasiun Tujuan</label>
                <select name="stasiun_tujuan_id" id="stasiun_tujuan" class="form-control" required>
                    <option value="" disabled selected>Pilih Stasiun Tujuan</option>
                    @foreach ($stasiuns as $stasiun)
                        <option value="{{ $stasiun->id }}">{{ $stasiun->nama_stasiun }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('rutes.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stasiunAsal = document.getElementById('stasiun_asal');
            const stasiunTujuan = document.getElementById('stasiun_tujuan');

            // Fungsi untuk menonaktifkan opsi yang sudah dipilih di dropdown lainnya
            function updateDropdown() {
                const asalValue = stasiunAsal.value;
                const tujuanValue = stasiunTujuan.value;

                // Looping melalui stasiun asal untuk menonaktifkan stasiun yang sudah dipilih di tujuan
                Array.from(stasiunAsal.options).forEach(option => {
                    option.disabled = (option.value === tujuanValue) || (option.value === '');
                });

                // Looping melalui stasiun tujuan untuk menonaktifkan stasiun yang sudah dipilih di asal
                Array.from(stasiunTujuan.options).forEach(option => {
                    option.disabled = (option.value === asalValue) || (option.value === '');
                });
            }

            // Menambahkan event listener untuk setiap perubahan di dropdown
            stasiunAsal.addEventListener('change', updateDropdown);
            stasiunTujuan.addEventListener('change', updateDropdown);

            // Memanggil updateDropdown pada saat halaman dimuat untuk memastikan dropdown dalam kondisi yang benar
            updateDropdown();
        });
    </script>
@endsection
@endsection
