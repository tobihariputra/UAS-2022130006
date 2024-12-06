@extends('layouts.app')

@section('content')
    <style>
        .containers {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 500px;
            margin-top: 3%;
            margin-left: 20%;
            margin-right: 20%;
            margin-bottom: 2%;
            max-width: 75%;
        }

        .ticket {
            padding: 20px;
            width: 100%;
            max-width: 700px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            position: relative;
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .ticket-header h1 {
            font-size: 24px;
            font-weight: bold;
            flex-basis: 100%;
        }

        .ticket-header p {
            font-size: 14px;
            margin: 0;
        }

        .qrcode {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .qrcode div {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qrcode img {
            max-width: 250px;
            height: auto;
        }

        .ticket-detail {
            margin-top: 20px;
        }

        .ticket-detail table {
            width: 100%;
            border-collapse: collapse;
            /* Add hover effect for the table */
            transition: all 0.3s ease;
        }

        .ticket-detail th,
        .ticket-detail td {
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }

        .ticket-detail th {
            background-color: #f4f4f4;
        }

        /* Add hover effect for rows */
        .ticket-detail tr:hover {
            background-color: #f0f0f0;
        }

        /* Add 3px horizontal line above the payment method section */
        .payment-method-line {
            border-top: 3px solid #000;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
            font-size: 12px;
        }

        /* Button styling */
        .print-btn,
        .back-btn {
            margin-top: 10%;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            border: none;
            background-color: #28a745;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .back-btn {
            left: 20px;
            background-color: #1f5176;
        }

        .print-btn:hover,
        .back-btn:hover {
            background-color: #00000074;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .containers {
                margin-top: 20%;
                margin-left: 20%;
                margin-right: 20%;
                margin-bottom: 2%;
                max-width: 75%;
            }

            .ticket-header h1 {
                font-size: 20px;
            }

            .ticket-detail th,
            .ticket-detail td {
                padding: 6px;
                font-size: 12px;
            }

            .ticket-detail td {
                word-break: break-word;
            }

            .footer {
                font-size: 10px;
                text-align: center;
                margin-top: 10px;
            }

            .print-btn,
            .back-btn {
                font-size: 12px;
                padding: 6px 12px;
            }

            .print-btn {
                right: 10px;
            }

            .back-btn {
                left: 10px;
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .ticket,
            .ticket * {
                visibility: visible;
            }

            .ticket {
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                box-sizing: border-box;
                overflow: hidden;
                padding: 10%;
            }

            @page {
                size: A4;
                margin: 0 auto;
            }
        }
    </style>

    <div class="containers">
        <a href="javascript:history.back()" class="back-btn">
            <i class="bi bi-arrow-left"></i>&nbsp; Kembali</a>
        <a href="javascript:void(0);" onclick="window.print();" class="print-btn">
            <i class="bi bi-printer"></i>&nbsp; Print</a>
    </div>

    <div class="ticket">
        <div class="ticket-header">
            <h1>Boarding Pass</h1>
            <p>Tanggal Pemesanan: {{ $latestPemesanan->created_at->format('d-m-Y') }}</p>
            <div class="qrcode">
                <div>
                    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode" />
                </div>
                <p style="font-weight: bold; font-size: 20px; text-align: right;">
                    {{ $latestPemesanan->jadwal->rute->nama_rute }}
                </p>
            </div>
            <p style="font-weight: bold; font-size: 20px;">
                {{ $latestPemesanan->kode_pemesanan }}
            </p>
        </div>

        <div class="ticket-detail">
            <table class="table table-striped">
                <tr>
                    <th>Email Pelanggan</th>
                    <th>Kode Booking</th>
                </tr>
                <tr>
                    <td>{{ $latestPemesanan->user->email }}</td>
                    <td>
                        @foreach ($latestPemesanan->tikets as $tiket)
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
                        @foreach ($latestPemesanan->tikets as $tiket)
                            {{ $tiket->jadwal->kereta->nama_kereta }}
                        @endforeach
                    </td>
                    <td>
                        @foreach ($latestPemesanan->tikets as $tiket)
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
                        @foreach ($latestPemesanan->tikets as $tiket)
                            {{ substr($tiket->kode_tiket, -2) }}{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </td>
                    <td>{{ $latestPemesanan->jumlah_tiket }}</td>
                </tr>
                <tr>
                    <th>Stasiun Asal</th>
                    <th>Tanggal/Waktu Berangkat</th>
                </tr>
                <tr>
                    <td>{{ $latestPemesanan->jadwal->rute->stasiunAsal->nama_stasiun }}</td>
                    <td>{{ $latestPemesanan->jadwal->waktu_berangkat }}</td>
                </tr>
                <tr>
                    <th>Stasiun Tujuan</th>
                    <th>Tanggal/Waktu Tiba</th>
                </tr>
                <tr>
                    <td>{{ $latestPemesanan->jadwal->rute->stasiunTujuan->nama_stasiun }}</td>
                    <td>{{ $latestPemesanan->jadwal->waktu_tiba }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>

                <!-- Add horizontal line above payment method -->
                <tr class="payment-method-line">
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td class="fw-bold">Metode Pembayaran</td>
                    <td class="fw-bold">{{ $latestPemesanan->payment_method }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <th>Rp{{ number_format($latestPemesanan->total_harga, 0, ',', '.') }}</th>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Check in at {{ $latestPemesanan->jadwal->rute->stasiunAsal->nama_stasiun }} on
                {{ $latestPemesanan->created_at->format('d-m-Y') }}</p>
        </div>
    </div>
@endsection
