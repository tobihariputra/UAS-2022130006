@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <div class="container-fluid shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Kelola Pemesanan oleh Admin</h1>
        <a href="{{ route('pemesanans.create') }}" class="btn btn-primary mb-3">Tambah Pemesanan</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($pemesanans->isNotEmpty())
            <div class="table-responsive">
                <table id="pemesanans-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Pemesanan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Kode Tiket</th>
                            <th>No Kursi</th>
                            <th>Nama</th>
                            <th>Berangkat</th>
                            <th>Tiba</th>
                            <th>Kelas Tiket</th>
                            <th>Jumlah Tiket</th>
                            <th>Total Bayar</th>
                            <th>Metode Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $pemesanan->kode_pemesanan }}</td>
                                <td>{{ $pemesanan->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @foreach ($pemesanan->tikets as $tiket)
                                        {{ $tiket->kode_tiket }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($pemesanan->tikets as $tiket)
                                        {{ substr($tiket->kode_tiket, -2) }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $pemesanan->user->name }}</td>
                                <td>{{ $pemesanan->jadwal->rute->stasiunAsal->nama_stasiun }} |
                                    {{ $pemesanan->jadwal->waktu_berangkat }}</td>
                                <td>{{ $pemesanan->jadwal->rute->stasiunTujuan->nama_stasiun }} |
                                    {{ $pemesanan->jadwal->waktu_tiba }}</td>
                                <td>
                                    @foreach ($pemesanan->tikets as $tiket)
                                        {{ $tiket->kelas_tiket }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $pemesanan->jumlah_tiket }}</td>
                                <td>Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $pemesanan->payment_method }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pemesanans.edit', $pemesanan->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('pemesanans.destroy', $pemesanan->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus pemesanan ini?')">Hapus</button>
                                    </form>
                                    <a href="{{ route('pemesanans.print', $pemesanan->id) }}" class="btn btn-success">Cetak
                                        Boarding Pass</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mt-3">Tidak ada pemesanan yang tersedia.</p>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('#pemesanans-table').DataTable({});

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
