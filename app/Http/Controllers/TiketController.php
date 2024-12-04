<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index(Request $request)
    {
        $jadwals = Jadwal::all();
        $tikets = collect();

        if ($request->has('jadwal_id') && $request->jadwal_id) {
            $tikets = Tiket::with('jadwal.kereta')
                ->where('jadwal_id', $request->jadwal_id)
                ->get();
        }
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Tiket', 'url' => route('tikets.index')],
        ];
        return view('tikets.index', compact('tikets', 'jadwals', 'breadcrumbs'));
    }

    public function create()
    {
        $jadwals = Jadwal::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Tiket', 'url' => route('tikets.index')],
            ['name' => 'Tambah Tiket'],
        ];
        return view('tikets.create', compact('jadwals', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'kelas_tiket' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal = Jadwal::find($request->jadwal_id);

        if (!$jadwal) {
            return back()->with('error', 'Jadwal tidak ditemukan');
        }

        // Ambil kata kedua dari nama kereta
        $namaKereta = strtoupper(substr($jadwal->kereta->nama_kereta, strpos($jadwal->kereta->nama_kereta, ' ') + 1));
        $kelasSingkat = strtoupper(substr($request->kelas_tiket, 0, 3));

        // Cari kode tiket terakhir untuk kelas dan jadwal yang sama
        $lastTicket = Tiket::query()
            ->where('jadwal_id', $jadwal->id)
            ->where('kelas_tiket', $request->kelas_tiket)
            ->latest('kode_tiket')
            ->first();

        $lastNumber = $lastTicket ? (int)substr($lastTicket->kode_tiket, -3) : 0;

        for ($i = 0; $i < $request->jumlah; $i++) {
            $nextNumber = str_pad($lastNumber + 1 + $i, 3, '0', STR_PAD_LEFT);
            $kodeTiket = "{$namaKereta}-{$kelasSingkat}-{$nextNumber}";

            // Periksa apakah kode tiket sudah ada untuk kombinasi jadwal_id dan kelas_tiket
            if (Tiket::where('jadwal_id', $jadwal->id)
                ->where('kelas_tiket', $request->kelas_tiket)
                ->where('kode_tiket', $kodeTiket)
                ->exists()
            ) {
                return back()->with('error', "Kode tiket {$kodeTiket} sudah ada, silakan coba lagi.");
            }

            // Buat tiket baru
            Tiket::create([
                'jadwal_id' => $jadwal->id,
                'kode_tiket' => $kodeTiket,
                'kelas_tiket' => $request->kelas_tiket,
                'harga' => $request->harga,
                'status' => 'available',
                'jumlah' => 1,
            ]);
        }

        return redirect()->route('tikets.index')->with('success', 'Tiket berhasil ditambahkan');
    }

    public function edit(Tiket $tiket)
    {
        $jadwals = Jadwal::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Tiket', 'url' => route('tikets.index')],
            ['name' => 'Edit Tiket', 'url' => route('tikets.edit', $tiket)],
        ];

        // Disable editing if status is unavailable
        if ($tiket->status === 'unavailable') {
            return back()->withErrors(['status' => 'Tiket yang sudah dipesan tidak dapat diubah.']);
        }

        return view('tikets.edit', compact('tiket', 'jadwals', 'breadcrumbs'));
    }

    public function update(Request $request, Tiket $tiket)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'kelas_tiket' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:available,unavailable',
        ]);

        // Prevent updating if the status is unavailable
        if ($tiket->status === 'unavailable') {
            return back()->withErrors(['status' => 'Tiket yang sudah dipesan tidak dapat diubah.']);
        }

        // Update the kode_tiket based on the kelas_tiket change
        $jadwal = Jadwal::find($request->jadwal_id);
        $namaKereta = strtoupper(substr($jadwal->kereta->nama_kereta, strpos($jadwal->kereta->nama_kereta, ' ') + 1));
        $kelasSingkat = strtoupper(substr($request->kelas_tiket, 0, 3));

        // Generate the new kode_tiket
        $newKodeTiket = "{$namaKereta}-{$kelasSingkat}-" . str_pad(substr($tiket->kode_tiket, -3), 3, '0', STR_PAD_LEFT);

        $tiket->update([
            'jadwal_id' => $request->jadwal_id,
            'kode_tiket' => $newKodeTiket,
            'kelas_tiket' => $request->kelas_tiket,
            'harga' => $request->harga,
            'status' => $request->status,
        ]);

        return redirect()->route('tikets.index')->with('success', 'Tiket berhasil diperbarui');
    }

    public function destroy(Tiket $tiket)
    {
        // Prevent deleting if the status is unavailable
        if ($tiket->status === 'unavailable') {
            return back()->withErrors(['status' => 'Tiket yang sudah dipesan tidak dapat dihapus.']);
        }

        $tiket->delete();
        return redirect()->route('tikets.index')->with('success', 'Tiket berhasil dihapus');
    }
}
