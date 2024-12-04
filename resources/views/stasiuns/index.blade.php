@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <h1>Kelola Stasiun</h1>
        <a href="{{ route('stasiuns.create') }}" class="btn btn-primary mb-3">Tambah Stasiun</a>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($stasiuns->isNotEmpty())
            <div class="table-responsive">
                <table id="stasiuns-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Stasiun</th>
                            <th>Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stasiuns as $stasiun)
                            <tr>
                                <td>{{ $stasiun->nama_stasiun }}</td>
                                <td>{{ $stasiun->kota }}</td>
                                <td>
                                    <a href="{{ route('stasiuns.edit', $stasiun->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('stasiuns.destroy', $stasiun->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada data stasiun.</p>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            $('#stasiuns-table').DataTable({});

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
