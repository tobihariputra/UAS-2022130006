<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kereta;
use App\Models\Rute;
use App\Models\Stasiun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    /**
     * Display search results for schedules.
     */
    public function search(Request $request)
    {
        $request->validate([
            'stasiun_asal' => 'required|exists:stasiuns,id',
            'stasiun_tujuan' => 'required|exists:stasiuns,id',
            'tanggal' => 'required|date',
        ]);

        $jadwals = Jadwal::with(['kereta', 'rute'])
            ->whereHas('rute', function ($query) use ($request) {
                $query->where('stasiun_asal_id', $request->stasiun_asal)
                    ->where('stasiun_tujuan_id', $request->stasiun_tujuan);
            })
            ->whereDate('waktu_berangkat', $request->tanggal)
            ->get()
            ->map(function ($jadwal) {
                $jadwal->durasi = $this->calculateDuration($jadwal->waktu_berangkat, $jadwal->waktu_tiba);
                return $jadwal;
            });

        // Jika ini adalah permintaan AJAX, kembalikan hanya tabel hasil pencarian
        if ($request->ajax()) {
            return view('partials.jadwal_table', compact('jadwals'))->render();
        }

        // Jika permintaan biasa, kembalikan view penuh
        $stasiuns = Stasiun::all();
        return view('home', compact('stasiuns', 'jadwals'));
    }




    /**
     * Calculate the duration between two timestamps.
     */
    private function calculateDuration($start, $end)
    {
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $interval = $start->diff($end);

        return $interval->format('%h jam %i menit');
    }

    /**
     * Display a listing of schedules with optional filters.
     */
    public function index(Request $request)
    {
        $request->validate([
            'stasiun_asal' => 'nullable|exists:stasiuns,id',
            'stasiun_tujuan' => 'nullable|exists:stasiuns,id',
            'tanggal_berangkat' => 'nullable|date',
        ]);

        $stasiuns = Stasiun::all();

        $jadwals = Jadwal::with(['kereta', 'rute.stasiunAsal', 'rute.stasiunTujuan']);

        if ($request->has(['stasiun_asal', 'stasiun_tujuan', 'tanggal_berangkat'])) {
            $jadwals = $jadwals->whereHas('rute', function ($query) use ($request) {
                $query->where('stasiun_asal_id', $request->stasiun_asal)
                    ->where('stasiun_tujuan_id', $request->stasiun_tujuan);
            })->whereDate('waktu_berangkat', $request->tanggal_berangkat);
        }

        $jadwals = $jadwals->get();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Jadwal', 'url' => route('jadwals.index')],
        ];

        return view('jadwals.index', compact('stasiuns', 'jadwals', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $keretas = Kereta::all();
        $rutes = Rute::all();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Jadwal', 'url' => route('jadwals.index')],
            ['name' => 'Tambah Jadwal'],
        ];

        return view('jadwals.create', compact('keretas', 'rutes', 'breadcrumbs'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kereta_id' => 'required|exists:keretas,id',
            'rute_id' => 'required|exists:rutes,id',
            'waktu_berangkat' => 'required|date_format:Y-m-d H:i',
            'waktu_tiba' => 'required|date_format:Y-m-d H:i|after:waktu_berangkat',
        ]);

        Jadwal::create($request->all());
        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified schedule.
     */
    public function edit(Jadwal $jadwal)
    {
        $keretas = Kereta::all();
        $rutes = Rute::all();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Jadwal', 'url' => route('jadwals.index')],
            ['name' => 'Edit Jadwal'],
        ];

        return view('jadwals.edit', compact('jadwal', 'keretas', 'rutes', 'breadcrumbs'));
    }

    /**
     * Update the specified schedule in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'kereta_id' => 'required|exists:keretas,id',
            'rute_id' => 'required|exists:rutes,id',
            'waktu_berangkat' => 'required|date',
            'waktu_tiba' => 'required|date|after:waktu_berangkat',
        ]);

        $jadwal->update($request->all());
        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
