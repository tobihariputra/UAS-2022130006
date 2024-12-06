@extends('layouts.panel')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
    <div class="container shadow p-4" style="background-color: #f9f9f9; border-radius: 10px;">
        <div class="d-flex justify-content-between align-items-center mx-2">
            <h1>Kelola Kereta</h1>
            <a href="{{ route('keretas.create') }}" class="btn btn-success">
                <i class="bi bi-bus-front"></i> &nbsp;Tambah Kereta</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($keretas->isNotEmpty())
            <div class="table-responsive">
                <table id="keretas-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kereta</th>
                            <th>Jenis Perjalanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keretas as $kereta)
                            <tr>
                                <td>{{ $kereta->nama_kereta }}</td>
                                <td>{{ $kereta->jenis }}</td>
                                <td>
                                    <a href="{{ route('keretas.edit', $kereta->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('keretas.destroy', $kereta->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Tidak ada data kereta.</p>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            $('#keretas-table').DataTable({});

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
