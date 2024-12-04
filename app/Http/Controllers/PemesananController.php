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
        return view('pemesanans.users_invoice');
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

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Pemesanan', 'url' => route('pemesanans.index')],
        ];
        return view('pemesanans.index', compact('pemesanans', 'breadcrumbs'));
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwals,id',
            'no_kursi' => 'required|array|min:1',
            'payment_method' => 'required|string',
        ]);

        // Ambil nomor kursi dari request
        $noKursi = $request->no_kursi;

        // Validasi apakah kursi yang dipilih masih tersedia
        $invalidSeats = Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->where('jadwal_id', $request->jadwal_id)
            ->where('status', 'unavailable')
            ->exists();

        if ($invalidSeats) {
            return redirect()->back()->withErrors(['no_kursi' => 'Salah satu nomor kursi yang dipilih sudah tidak tersedia.']);
        }

        // Ubah status tiket lama menjadi "available"
        foreach ($pemesanan->tikets as $tiket) {
            $tiket->update(['status' => 'available']);
        }

        // Tandai tiket baru sebagai "unavailable"
        Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
            ->whereIn(DB::raw('SUBSTRING(kode_tiket, -2)'), $noKursi)
            ->update(['status' => 'unavailable']);

        // Update pemesanan
        $pemesanan->update([
            'user_id' => $request->user_id,
            'jadwal_id' => $request->jadwal_id,
            'jumlah_tiket' => count($noKursi),
            'total_harga' => Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)->first()->harga * count($noKursi),
            'payment_method' => $request->payment_method,
        ]);

        // Perbarui hubungan antara tiket dan pemesanan
        $pemesanan->tikets()->detach(); // Hapus semua relasi tiket sebelumnya
        foreach ($noKursi as $kursi) {
            $tiket = Tiket::where('kelas_tiket', $pemesanan->tikets->first()->kelas_tiket ?? null)
                ->where(DB::raw('SUBSTRING(kode_tiket, -2)'), $kursi)
                ->first();

            if ($tiket) {
                $pemesanan->tikets()->attach($tiket->id);
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
