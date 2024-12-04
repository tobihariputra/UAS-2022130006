<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\KelasTiket;
use App\Models\Kereta;
use App\Models\Pemesanan;
use App\Models\Rute;
use App\Models\Stasiun;
use App\Models\Tiket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $jadwalCount = Jadwal::count();
        $keretaCount = Kereta::count();
        $stasiunCount = Stasiun::count();
        $ticketCount = Tiket::count();
        $pemesananCount = Pemesanan::count();
        $ruteCount = Rute::count();

        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Dashboard']
        ];

        return view('admin.dashboard', compact('userCount', 'jadwalCount', 'keretaCount', 'stasiunCount', 'ticketCount', 'ruteCount', 'pemesananCount', 'breadcrumbs'));
    }
}
