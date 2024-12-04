<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Stasiun;
use App\Models\Tiket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $stasiuns = Stasiun::all();
        $jadwals = Jadwal::all();
        $tikets = Tiket::all();
        if ($request->has(['stasiun_asal', 'stasiun_tujuan', 'tanggal'])) {
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
        }

        return view('home', compact('stasiuns', 'jadwals', 'tikets'));
    }

    private function calculateDuration($start, $end)
    {
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $interval = $start->diff($end);

        return $interval->format('%h jam %i menit');
    }
}
