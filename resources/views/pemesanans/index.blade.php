@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="container-fluid shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <div class="d-flex justify-content-between align-items-center mx-2">
            <h1>Kelola Pemesanan oleh Admin</h1>
            <a href="{{ route('pemesanans.create') }}" class="btn btn-success">
                <i class="bi bi-receipt"></i> &nbsp;Tambah Pemesanan</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($pemesanans->isNotEmpty())
            <div class="table-responsive">
                <table id="pemesanans-table" class="table table-bordered table-striped text-nowrap">
                    <thead>
                        <tr>
                            <th>No Pemesanan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Kode Pemesanan</th>
                            <th>Kode Tiket</th>
                            <th>Rute</th>
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
                                <td>{{ $pemesanan->id }}</td>
                                <td>{{ $pemesanan->created_at->format('d-m-Y') }}</td>
                                <td>{{ $pemesanan->kode_pemesanan }}</td>
                                <td>
                                    @foreach ($pemesanan->tikets as $tiket)
                                        {{ $tiket->kode_tiket }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td>{{ $pemesanan->jadwal->rute->nama_rute }}</td>
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
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('pemesanans.destroy', $pemesanan->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus pemesanan ini?')">
                                            <i class="bi bi-trash"></i></button>
                                        <a href="{{ route('pemesanans.print', $pemesanan->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="bi bi-printer"></i></a>
                                    </form>
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



    <div class="container mt-5 shadow p-4" style="background-color: #ffffff4a;">
        <canvas id="salesChart"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');

        const labels = @json($pemesanan_per_bulan->keys());
        const data = @json($pemesanan_per_bulan->values()).map(value => value);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'TOTAL PENJUALAN per BULAN (Rp)',
                    data: data,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Rp' + tooltipItem.raw.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>

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
