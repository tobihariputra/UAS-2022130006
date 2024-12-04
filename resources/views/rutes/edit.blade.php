@extends('layouts.panel')

@section('title', 'Edit Rute')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Edit Rute</h1>
        <form action="{{ route('rutes.update', $rute->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nama_rute">Nama Rute</label>
                <input type="text" name="nama_rute" id="nama_rute" class="form-control" value="{{ $rute->nama_rute }}"
                    required>
            </div>
            <div class="form-group mb-3">
                <label for="stasiun_asal">Stasiun Asal</label>
                <select name="stasiun_asal_id" id="stasiun_asal" class="form-control" required>
                    <option value="">Pilih Stasiun Asal</option>
                    @foreach ($stasiuns as $stasiun)
                        <option value="{{ $stasiun->id }}" {{ $rute->stasiun_asal_id == $stasiun->id ? 'selected' : '' }}>
                            {{ $stasiun->nama_stasiun }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="stasiun_tujuan">Stasiun Tujuan</label>
                <select name="stasiun_tujuan_id" id="stasiun_tujuan" class="form-control" required>
                    <option value="">Pilih Stasiun Tujuan</option>
                    @foreach ($stasiuns as $stasiun)
                        <option value="{{ $stasiun->id }}" {{ $rute->stasiun_tujuan_id == $stasiun->id ? 'selected' : '' }}>
                            {{ $stasiun->nama_stasiun }}
                        </option>
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
