@extends('layouts.panel')

@section('content')
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Tambah Pemesanan</h1>

        <form action="{{ route('pemesanans.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="user_id">User</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Pilih User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="jadwal_id">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}">
                            {{ $jadwal->kereta->nama_kereta }} | {{ $jadwal->rute->nama_rute }} |
                            {{ $jadwal->waktu_berangkat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="kelas_tiket">Pilih Kelas Tiket</label>
                <select name="kelas_tiket" id="kelas_tiket" class="form-control" required>
                    <option value="">-- Pilih Kelas Tiket --</option>
                    <option value="Eksekutif">Eksekutif</option>
                    <option value="Bisnis">Bisnis</option>
                    <option value="Ekonomi">Ekonomi</option>
                </select>
            </div>

            <div class="form-group mb-3" id="seat-selection" style="display: none;">
                <label>Pilih Nomor Kursi</label>
                <div id="seat-options" class="d-grid" style="grid-template-columns: repeat(16, 1fr); gap: 10px;"></div>
            </div>

            <div class="form-group mb-3">
                <label for="payment_method">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash">Cash</option>
                    <option value="Debit/Credit Card">Debit/Credit Card</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('pemesanans.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script>
        const availableSeats = @json($availableSeats); // Data dari backend
        // Menangani perubahan pada kelas tiket dan jadwal
        document.getElementById('kelas_tiket').addEventListener('change', updateSeats);
        document.getElementById('jadwal_id').addEventListener('change', updateSeats);

        function updateSeats() {
            const jadwalId = document.getElementById('jadwal_id').value;
            const kelas = document.getElementById('kelas_tiket').value;
            const seatSelection = document.getElementById('seat-selection');
            const seatOptions = document.getElementById('seat-options');

            seatOptions.innerHTML = ''; // Reset konten kursi

            // Periksa apakah jadwal dan kelas tiket valid, lalu tampilkan kursi
            if (jadwalId && kelas && availableSeats[jadwalId] && availableSeats[jadwalId][kelas] && availableSeats[jadwalId]
                [kelas].length > 0) {
                seatSelection.style.display = 'block';

                availableSeats[jadwalId][kelas].forEach(seat => {
                    const container = document.createElement('div');
                    container.classList.add('text-center');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'no_kursi[]';
                    checkbox.value = seat;
                    checkbox.id = `seat-${seat}`;
                    checkbox.classList.add('form-check-input');

                    const label = document.createElement('label');
                    label.htmlFor = `seat-${seat}`;
                    label.textContent = seat;
                    label.style.display = 'block'; // Pastikan label muncul di bawah checkbox
                    label.style.marginTop = '5px';

                    container.appendChild(checkbox);
                    container.appendChild(label);

                    seatOptions.appendChild(container);
                });
            } else {
                seatSelection.style.display = 'none';
            }
        }
    </script>
@endsection
