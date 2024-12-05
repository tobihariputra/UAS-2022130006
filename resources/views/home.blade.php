@extends('layouts.app')

@section('content')
    <!-- Section: Video Background -->
    <div id="home">
        <div class="video-container position-relative" style="height: 120vh; overflow: hidden;">
            <video autoplay loop muted playsinline class="position-absolute w-100 h-100" style="object-fit: cover;">
                <source src="{{ asset('videos/videobg.mp4') }}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
            <div class="position-absolute w-100 h-100 d-flex align-items-center justify-content-center"
                style="z-index: 2; background: rgba(0, 0, 0, 0.5);">
                <h1 class="text-white text-center fw-bold display-4">Selamat Datang di Sistem Pemesanan Tiket Kereta</h1>
            </div>
        </div>
    </div>

    <!-- Section: Form Pemesanan Tiket -->
    <div class="container mt-5" style="min-height: 30vh;">
        <h3 class="text-center mb-4">Pemesanan Tiket Kereta</h3>
        <div class="card p-4">
            <form id="searchForm">
                <div class="row">
                    <!-- Stasiun Asal -->
                    <div class="col-12 col-md-4 mb-3">
                        <label for="stasiun_asal">Stasiun Asal</label>
                        <select name="stasiun_asal" id="stasiun_asal" class="form-control" required>
                            <option value="" disabled selected>Pilih Stasiun Asal</option>
                            @foreach ($stasiuns as $stasiun)
                                <option value="{{ $stasiun->id }}">{{ $stasiun->nama_stasiun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Stasiun Tujuan -->
                    <div class="col-12 col-md-4 mb-3">
                        <label for="stasiun_tujuan">Stasiun Tujuan</label>
                        <select name="stasiun_tujuan" id="stasiun_tujuan" class="form-control" required>
                            <option value="" disabled selected>Pilih Stasiun Tujuan</option>
                            @foreach ($stasiuns as $stasiun)
                                <option value="{{ $stasiun->id }}">{{ $stasiun->nama_stasiun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tanggal -->
                    <div class="col-12 col-md-4 mb-3">
                        <label for="tanggal" class="form-label">Tanggal Berangkat</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" id="searchButton" class="btn btn-primary">Cari Jadwal</button>
                </div>
            </form>

            <!-- Section: Hasil Pencarian -->
            <div id="resultSection" class="mt-4">
                <!-- Hasil pencarian akan dimuat di sini -->
            </div>
        </div>
    </div>

    <!-- Section: Keunggulan Layanan -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Mengapa Beli Tiket Kereta di Sini?</h2>
        <div class="row g-4">
            @php
                $features = [
                    [
                        'src' => '1.png',
                        'title' => 'Keamanan Terjaga',
                        'text' =>
                            'Didukung oleh keamanan enkripsi berstandar ISO 27001 untuk menjaga kerahasiaan informasi Anda.',
                    ],
                    [
                        'src' => '2.png',
                        'title' => 'Beli Tiket Jauh Hari H-30',
                        'text' =>
                            'Beli tiket kereta hingga 30 hari sebelum berangkat, tak perlu khawatir kehabisan tiket.',
                    ],
                    [
                        'src' => '3.png',
                        'title' => 'Pencarian Tiket Kereta Terlengkap',
                        'text' =>
                            'Tersedia tiket kereta lengkap dengan berbagai pilihan kelas, seperti ekonomi, bisnis, eksekutif, dan lainnya.',
                    ],
                    [
                        'src' => '4.png',
                        'title' => 'Temukan Harga Tiket Kereta Secara Praktis',
                        'text' => 'Cari tiket online, pilih tanggal dan jadwal dengan mudah tanpa antre panjang.',
                    ],
                    [
                        'src' => '5.png',
                        'title' => 'Bebas Pilih Metode Pembayaran',
                        'text' =>
                            'Berbagai metode pembayaran, seperti transfer bank, kartu kredit, hingga e-money tersedia.',
                    ],
                    [
                        'src' => '6.png',
                        'title' => 'Bebas Hambatan',
                        'text' => 'Beli tiket kapan saja dan di mana saja tanpa antre lama di loket.',
                    ],
                ];
            @endphp
            @foreach ($features as $feature)
                <div class="col-12 col-md-4">
                    <div class="card h-100 text-center p-3">
                        <img src="{{ asset('images/' . $feature['src']) }}" class="card-img-top mx-auto"
                            alt="{{ $feature['title'] }}" style="width: 150px;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $feature['title'] }}</h5>
                            <p class="card-text">{{ $feature['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section: Slider -->
    <div class="container my-5">
        <h2 class="text-center mb-4">RASAKAN PENGALAMAN KESERUANNYA NAIK KERETA BERSAMA KAMI</h2>
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
                        <img src="{{ asset('images/slider' . $i . '.jpg') }}" class="d-block mx-auto"
                            style="max-height: 70%; max-width: 70%" alt="Slider {{ $i }}">
                    </div>
                @endfor
            </div>
            <!-- Tombol panah kiri dan kanan -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly"
                data-bs-slide="prev" style="background-color: red;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly"
                data-bs-slide="next" style="background-color: red;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#carouselExampleSlidesOnly').carousel({
                interval: 1,
            });
        });
    </script>


    <!-- Section: Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchButton').on('click', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                // Ambil data form
                const stasiunAsal = $('#stasiun_asal').val();
                const stasiunTujuan = $('#stasiun_tujuan').val();
                const tanggal = $('#tanggal').val();

                // Validasi input
                if (!stasiunAsal || !stasiunTujuan || !tanggal) {
                    alert('Semua kolom harus diisi.');
                    return;
                }

                // Kirim AJAX request
                $.ajax({
                    url: "{{ route('jadwals.search') }}", // Route pencarian
                    method: "GET",
                    data: {
                        stasiun_asal: stasiunAsal,
                        stasiun_tujuan: stasiunTujuan,
                        tanggal: tanggal
                    },
                    success: function(response) {
                        $('#resultSection').html(response);
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mencari jadwal.');
                    },
                });
            });
        });
    </script>
@endsection
