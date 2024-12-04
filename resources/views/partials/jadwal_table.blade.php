@if (isset($jadwals) && count($jadwals) > 0)
    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach ($jadwals as $jadwal)
                <div class="col-md-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title m-0">
                                    <strong>{{ $jadwal->kereta->nama_kereta }}</strong>
                                </h5>
                                <span class="badge bg-primary">{{ $jadwal->kelas }}</span>
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($jadwal->waktu_berangkat)->format('d M Y') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">
                                        {{ \Carbon\Carbon::parse($jadwal->waktu_berangkat)->format('H:i') }}</h6>
                                    <small class="text-muted">Berangkat</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ \Carbon\Carbon::parse($jadwal->waktu_tiba)->format('H:i') }}
                                    </h6>
                                    <small class="text-muted">Tiba</small>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $jadwal->durasi }}</h6>
                                    <small class="text-muted">Durasi</small>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Rp {{ number_format($jadwal->kereta->harga, 0, ',', '.') }}</h6>
                                <a href="" class="btn btn-warning btn-sm">Pilih</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="text-center mt-5">
        <h5>Tidak ada jadwal tersedia.</h5>
    </div>
@endif
