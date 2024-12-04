@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Kelola Tiket yang Bisa Dibeli oleh Pelanggan</h1>
        <a href="{{ route('tikets.create') }}" class="btn btn-primary mb-3">Tambah Tiket</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('tikets.index') }}">
            <div class="form-group">
                <label for="jadwal_id">Pilih Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ request('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                            {{ $jadwal->kereta->nama_kereta }} | {{ $jadwal->rute->nama_rute }} |
                            {{ $jadwal->waktu_berangkat }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        @if ($tikets->isNotEmpty())
            <div class="table-responsive">
                <table id="tikets-table" class="table responsive mt-3">
                    <thead>
                        <tr>
                            <th>Kode Tiket</th>
                            <th>Nama Kereta</th>
                            <th>Kelas Tiket</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tikets as $tiket)
                            <tr>
                                <td>{{ $tiket->kode_tiket }}</td>
                                <td>{{ $tiket->jadwal->kereta->nama_kereta }}</td>
                                <td>{{ $tiket->kelas_tiket }}</td>
                                <td>Rp. {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                                <td>{{ $tiket->jumlah }}</td>
                                <td>
                                    <span class="badge {{ $tiket->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $tiket->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tikets.edit', $tiket->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('tikets.destroy', $tiket->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus tiket ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mt-3">Tidak ada tiket untuk jadwal yang dipilih.</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#tikets-table').DataTable({});

            // Remove alert after 5 seconds
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.style.transition = 'opacity 0.9s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 350);
                }
            }, 5000);
        });
    </script>
@endsection
