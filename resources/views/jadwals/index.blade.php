@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Kelola Jadwal Kereta</h1>
        <a href="{{ route('jadwals.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($jadwals->isNotEmpty())
            <div class="table-responsive">
                <table id="jadwals-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kereta</th>
                            <th>Rute</th>
                            <th>Waktu Berangkat</th>
                            <th>Waktu Tiba</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($jadwals && $jadwals->count() > 0)
                            @foreach ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->kereta->nama_kereta }}</td>
                                    <td>{{ $jadwal->rute->nama_rute }}</td>
                                    <td>{{ $jadwal->waktu_berangkat }}</td>
                                    <td>{{ $jadwal->waktu_tiba }}</td>
                                    <td>
                                        <a href="{{ route('jadwals.edit', $jadwal->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('jadwals.destroy', $jadwal->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Data jadwal kereta tidak tersedia.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada data jadwal kereta.</p>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            $('#jadwals-table').DataTable({});

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
