<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Jadwal;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

class PemesananController extends Controller
{
    public function userinvoice()
    {
        $pemesanans = Pemesanan::where('user_id', Auth::id())->get();
        $latestPemesanan = $pemesanans->last();  // Get the last pemesanan
        $barcode = base64_encode((new BarcodeGeneratorPNG())->getBarcode($latestPemesanan->kode_pemesanan, BarcodeGeneratorPNG::TYPE_CODE_128));

        return view('pemesanans.users_invoice', compact('latestPemesanan', 'barcode'));
    }
    public function userpayment()
    {
        return view('pemesanans.users_payment');
    }

    public function usercreate()
    {
        $users = User::all();
        $jadwals = Jadwal::with('kereta')->get();

        // Mengambil nomor kursi berdasarkan kombinasi jadwal dan kelas tiket
        $availableSeats = [];
        foreach ($jadwals as $jadwal) {
            foreach (['Eksekutif', 'Bisnis', 'Ekonomi'] as $kelas) {
                $availableSeats[$jadwal->id][$kelas] = Tiket::where('jadwal_id', $jadwal->id)
                    ->where('kelas_tiket', $kelas)
                    ->where('status', 'available')
                    ->get()
                    ->map(function ($tiket) {
                        return substr($tiket->kode_tiket, -2); // Ambil 2 digit terakhir dari kode tiket
                    })
                    ->toArray();
            }
        }
        return view('pemesanans.users_create', compact('users', 'jadwals', 'availableSeats'));
    }



    public function userstore(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'kelas_tiket' => 'required|string',
            'no_kursi' => 'required|array|min:1',
            'payment_method' => 'required|string',
        ]);

        // Ambil nomor kursi dari request
        $noKursi = $request->no_kursi;

        // Cek apakah tiket dengan nomor kursi tersebut sudah dipesan
        $invalidSeats = Tiket::where('kelas_tiket', $request->kelas_tiket)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->where('jadwal_id', $request->jadwal_id)  // Memastikan kursi adalah untuk jadwal yang benar
            ->where('status', 'unavailable')

            ->exists();

        if ($invalidSeats) {
            return redirect()->back()->withErrors(['no_kursi' => 'Salah satu nomor kursi sudah dipesan.']);
        }

        // Tandai tiket yang dipilih sebagai unavailable
        Tiket::where('kelas_tiket', $request->kelas_tiket)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->where('jadwal_id', $request->jadwal_id) // Pastikan sesuai jadwal
            ->update(['status' => 'unavailable']);

        // Hitung total harga berdasarkan kelas tiket
        $hargaPerTiket = Tiket::where('kelas_tiket', $request->kelas_tiket)->first()->harga;
        $totalHarga = $hargaPerTiket * count($noKursi);

        // Buat kode pemesanan
        $kodePemesanan = 'PM-' . strtoupper(Str::random(8));

        // Simpan pemesanan
        $pemesanan = Pemesanan::create([
            'user_id' => $request->user_id,
            'jadwal_id' => $request->jadwal_id,
            'jumlah_tiket' => count($noKursi),
            'total_harga' => $totalHarga,
            'kode_pemesanan' => $kodePemesanan,
            'payment_method' => $request->payment_method,
        ]);

        // Simpan hubungan tiket dan pemesanan
        foreach ($noKursi as $kursi) {
            $tiket = Tiket::where('kelas_tiket', $request->kelas_tiket)
                ->where(DB::raw('SUBSTRING(kode_tiket, -2)'), $kursi)
                ->where('jadwal_id', $request->jadwal_id) // Pastikan sesuai jadwal

                ->first();

            if ($tiket) {
                // Mengaitkan tiket dengan pemesanan
                $pemesanan->tikets()->attach($tiket->id);
            }
        }

        // Redirect ke halaman pemesanan dengan pesan sukses
        return redirect()->route(route: 'pemesanans.users.payment')->with('success', 'Pemesanan berhasil dilakukan');
    }


    public function print($id)
    {
        // Ambil data pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id);
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($pemesanan->kode_pemesanan, BarcodeGeneratorPNG::TYPE_CODE_128));
        // Proses untuk generate PDF
        $pdf = Pdf::loadView('pemesanans.print', compact('pemesanan', 'barcode'));
        // Return PDF sebagai response
        return $pdf->download('ticket-' . $pemesanan->kode_pemesanan . '.pdf');
    }

    public function index()
    {
        $pemesanans = Pemesanan::with([
            'user',
            'jadwal.rute.stasiunAsal',
            'jadwal.rute.stasiunTujuan',
            'tikets'
        ])->get();

        // Mengambil data pemesanan dan mengelompokkan berdasarkan bulan
        $pemesanan_per_bulan = $pemesanans->groupBy(function ($item) {
            return $item->created_at->format('Y-m'); // Format Year-Month
        })->map(function ($group) {
            return $group->sum('total_harga'); // Total bayar per bulan
        });


        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Pemesanan', 'url' => route('pemesanans.index')],
        ];
        return view('pemesanans.index', compact('pemesanans', 'pemesanan_per_bulan', 'breadcrumbs'));
    }

    public function create()
    {
        $users = User::all();
        $jadwals = Jadwal::with('kereta')->get();

        // Mengambil nomor kursi berdasarkan kombinasi jadwal dan kelas tiket
        $availableSeats = [];
        foreach ($jadwals as $jadwal) {
            foreach (['Eksekutif', 'Bisnis', 'Ekonomi'] as $kelas) {
                $availableSeats[$jadwal->id][$kelas] = Tiket::where('jadwal_id', $jadwal->id)
                    ->where('kelas_tiket', $kelas)
                    ->where('status', 'available')
                    ->get()
                    ->map(function ($tiket) {
                        return substr($tiket->kode_tiket, -2); // Ambil 2 digit terakhir dari kode tiket
                    })
                    ->toArray();
            }
        }

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Pemesanan', 'url' => route('pemesanans.index')],
            ['name' => 'Tambah Pemesanan'],
        ];

        return view('pemesanans.create', compact('users', 'jadwals', 'availableSeats', 'breadcrumbs'));
    }



    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'kelas_tiket' => 'required|string',
            'no_kursi' => 'required|array|min:1',
            'payment_method' => 'required|string',
        ]);

        // Ambil nomor kursi dari request
        $noKursi = $request->no_kursi;

        // Cek apakah tiket dengan nomor kursi tersebut sudah dipesan
        $invalidSeats = Tiket::where('kelas_tiket', $request->kelas_tiket)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->where('jadwal_id', $request->jadwal_id)  // Memastikan kursi adalah untuk jadwal yang benar
            ->where('status', 'unavailable')

            ->exists();

        if ($invalidSeats) {
            return redirect()->back()->withErrors(['no_kursi' => 'Salah satu nomor kursi sudah dipesan.']);
        }

        // Tandai tiket yang dipilih sebagai unavailable
        Tiket::where('kelas_tiket', $request->kelas_tiket)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->where('jadwal_id', $request->jadwal_id) // Pastikan sesuai jadwal
            ->update(['status' => 'unavailable']);

        // Hitung total harga berdasarkan kelas tiket
        $hargaPerTiket = Tiket::where('kelas_tiket', $request->kelas_tiket)->first()->harga;
        $totalHarga = $hargaPerTiket * count($noKursi);

        // Buat kode pemesanan
        $kodePemesanan = 'PM-' . strtoupper(Str::random(8));

        // Simpan pemesanan
        $pemesanan = Pemesanan::create([
            'user_id' => $request->user_id,
            'jadwal_id' => $request->jadwal_id,
            'jumlah_tiket' => count($noKursi),
            'total_harga' => $totalHarga,
            'kode_pemesanan' => $kodePemesanan,
            'payment_method' => $request->payment_method,
        ]);

        // Simpan hubungan tiket dan pemesanan
        foreach ($noKursi as $kursi) {
            $tiket = Tiket::where('kelas_tiket', $request->kelas_tiket)
                ->where(DB::raw('SUBSTRING(kode_tiket, -2)'), $kursi)
                ->where('jadwal_id', $request->jadwal_id) // Pastikan sesuai jadwal

                ->first();

            if ($tiket) {
                // Mengaitkan tiket dengan pemesanan
                $pemesanan->tikets()->attach($tiket->id);
            }
        }

        // Redirect ke halaman pemesanan dengan pesan sukses
        return redirect()->route(route: 'pemesanans.index')->with('success', 'Pemesanan berhasil dilakukan');
    }


    public function edit(Pemesanan $pemesanan)
    {
        $users = User::all();
        $jadwals = Jadwal::with('kereta')->get();

        // Ambil kelas tiket yang dipilih pada pemesanan sebelumnya
        $kelasTiket = $pemesanan->tikets->first()->kelas_tiket ?? null;

        // Ambil semua nomor kursi yang tersedia untuk kelas tiket dan jadwal yang dipilih
        $availableSeats = Tiket::where('kelas_tiket', $kelasTiket)
            ->where('status', 'available')
            ->where('jadwal_id', $pemesanan->jadwal_id)
            ->get()
            ->map(fn($tiket) => substr($tiket->kode_tiket, -2)) // Ambil 2 digit terakhir dari kode tiket
            ->toArray();

        // Ambil nomor kursi yang sudah dipilih pada pemesanan
        $selectedSeats = $pemesanan->tikets->map(fn($tiket) => substr($tiket->kode_tiket, -2));

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Pemesanan', 'url' => route('pemesanans.index')],
            ['name' => 'Edit Pemesanan'],
        ];

        return view('pemesanans.edit', compact('pemesanan', 'users', 'jadwals', 'availableSeats', 'selectedSeats', 'breadcrumbs', 'kelasTiket'));
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        // Validasi umum untuk fields lainnya
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'payment_method' => 'required|string',
        ]);

        // Cek apakah ada perubahan pada no_kursi (jika tidak ada, abaikan validasi no_kursi)
        $noKursi = $request->no_kursi ?? [];

        // Jika ada perubahan pada no_kursi, lakukan validasi
        if (!empty($noKursi)) {
            $request->validate([
                'no_kursi' => 'required|array|min:1',
            ]);

            // Validasi apakah kursi yang dipilih masih tersedia
            $invalidSeats = Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
                ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
                ->where('jadwal_id', $request->jadwal_id)
                ->where('status', 'unavailable')
                ->exists();

            if ($invalidSeats) {
                return redirect()->back()->withErrors(['no_kursi' => 'Salah satu nomor kursi yang dipilih sudah tidak tersedia.']);
            }
        }

        // Jika no_kursi tidak diubah, maka $noKursi akan kosong dan tidak melakukan perubahan status kursi
        if (!empty($noKursi)) {
            // Ubah status tiket lama menjadi "available"
            foreach ($pemesanan->tikets as $tiket) {
                $tiket->update(['status' => 'available']);
            }

            // Tandai tiket baru sebagai "unavailable"
            Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
                ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
                ->update(['status' => 'unavailable']);
        }

        // Update pemesanan tanpa mengubah kursi jika no_kursi tidak dikirimkan
        $pemesanan->update([
            'user_id' => $request->user_id,
            'jadwal_id' => $request->jadwal_id,
            'jumlah_tiket' => !empty($noKursi) ? count($noKursi) : $pemesanan->jumlah_tiket,  // Hanya hitung jumlah tiket jika ada perubahan kursi
            'total_harga' => Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
                ->first()->harga * (count($noKursi) > 0 ? count($noKursi) : $pemesanan->jumlah_tiket),  // Total harga dihitung berdasarkan kursi yang dipilih
            'payment_method' => $request->payment_method,
        ]);

        // Perbarui hubungan antara tiket dan pemesanan jika ada perubahan kursi
        if (!empty($noKursi)) {
            $pemesanan->tikets()->detach(); // Hapus semua relasi tiket sebelumnya
            foreach ($noKursi as $kursi) {
                $tiket = Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
                    ->where(DB::raw('SUBSTRING(kode_tiket, -2)'), $kursi)
                    ->first();

                if ($tiket) {
                    $pemesanan->tikets()->attach($tiket->id);
                }
            }
        }

        return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Ubah status tiket menjadi available kembali
        foreach ($pemesanan->tikets as $tiket) {
            $tiket->update(['status' => 'available']);
        }

        // Hapus pemesanan
        $pemesanan->delete();

        return redirect()->route('pemesanans.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
}
