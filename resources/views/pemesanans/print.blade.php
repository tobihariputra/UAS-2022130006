<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .ticket {
            padding: 20px;
            width: 90%;
            max-width: 700px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 20px;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .ticket-header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .qrcode img {
            max-width: 250px;
            height: 50px;
        }

        .ticket-detail table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-detail th,
        .ticket-detail td {
            padding: 8px;
            text-align: left;
        }

        .ticket-detail th {
            background-color: #f4f4f4;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>Boarding Pass</h1>
            <p>Tanggal Pemesanan : {{ $pemesanan->created_at->format('d-m-Y') }}</p>
            <div class="qrcode" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode" style="max-height: 50px;" />
                    <p style="font-weight: bold; font-size: 20px; margin-top: 10px;">
                        {{ $pemesanan->kode_pemesanan }}
                    </p>
                </div>
                <p style="font-weight: bold; font-size: 20px; margin: 0; text-align: right;">
                    {{ $pemesanan->jadwal->rute->nama_rute }}
                </p>
            </div>
        </div>




        <div class="ticket-detail">
            <table>
                <tr>
                    <th>Email Pelanggan</th>
                    <th>Kode Booking</th>
                </tr>
                <tr>
                    <td>{{ $pemesanan->user->email }}</td>
                    <td>
                        @foreach ($pemesanan->tikets as $tiket)
                            {{ $tiket->kode_tiket }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Kereta Api</th>
                    <th>Tipe Penumpang</th>
                </tr>
                <tr>
                    <td>
                        @foreach ($pemesanan->tikets as $tiket)
                            {{ $tiket->jadwal->kereta->nama_kereta }}
                        @endforeach
                    </td>
                    <td>
                        @foreach ($pemesanan->tikets as $tiket)
                            {{ $tiket->kelas_tiket }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Nomor Kursi</th>
                    <th>Jumlah Tiket</th>
                </tr>
                <tr>
                    <td>
                        @foreach ($pemesanan->tikets as $tiket)
                            {{ substr($tiket->kode_tiket, -2) }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                    <td>{{ $pemesanan->jumlah_tiket }}</td>
                </tr>
                <tr>
                    <th>Stasiun Asal</th>
                    <th>Tanggal/Waktu Berangkat</th>
                </tr>
                <tr>
                    <td>{{ $pemesanan->jadwal->rute->stasiunAsal->nama_stasiun }}</td>
                    <td>{{ $pemesanan->jadwal->waktu_berangkat }}</td>
                </tr>
                <tr>
                    <th>Stasiun Tujuan</th>
                    <th>Tanggal/Waktu Tiba</th>
                </tr>
                <tr>
                    <td>{{ $pemesanan->jadwal->rute->stasiunTujuan->nama_stasiun }}</td>
                    <td>{{ $pemesanan->jadwal->waktu_tiba }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <th>Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</th>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Check in at {{ $pemesanan->jadwal->rute->stasiunAsal->nama_stasiun }} on
                {{ $pemesanan->created_at->format('d-m-Y') }}</p>
        </div>
    </div>
</body>

</html>
