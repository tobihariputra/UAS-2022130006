<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Stasiun;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rutes = Rute::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Rute', 'url' => route('rutes.index')]
        ];
        return view('rutes.index', compact('rutes', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stasiuns = Stasiun::all(); // Ambil semua stasiun
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Rute', 'url' => route('rutes.index')],
            ['name' => 'Tambah Rute'],
        ];
        return view('rutes.create', compact('stasiuns', 'breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_rute' => 'required|string|max:255',
            'stasiun_asal_id' => 'required|exists:stasiuns,id', // Pastikan ID yang dipilih valid
            'stasiun_tujuan_id' => 'required|exists:stasiuns,id', // Pastikan ID yang dipilih valid
        ]);

        Rute::create([
            'nama_rute' => $request->nama_rute,
            'stasiun_asal_id' => $request->stasiun_asal_id,
            'stasiun_tujuan_id' => $request->stasiun_tujuan_id,
        ]);

        return redirect()->route('rutes.index')->with('success', 'Rute berhasil ditambahkan');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rute $rute)
    {
        $stasiuns = Stasiun::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Rute', 'url' => route('rutes.index')],
            ['name' => 'Edit Rute'],
        ];
        return view('rutes.edit', compact('rute', 'stasiuns', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rute $rute)
    {
        $request->validate([
            'nama_rute' => 'required|string|max:255',
            'stasiun_asal_id' => 'required|exists:stasiuns,id', // Pastikan ID yang dipilih valid
            'stasiun_tujuan_id' => 'required|exists:stasiuns,id', // Pastikan ID yang dipilih valid
        ]);

        $rute->update([
            'nama_rute' => $request->nama_rute,
            'stasiun_asal_id' => $request->stasiun_asal_id,
            'stasiun_tujuan_id' => $request->stasiun_tujuan_id,
        ]);

        return redirect()->route('rutes.index')->with('success', 'Rute berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rute $rute)
    {
        $rute->delete();

        return redirect()->route('rutes.index')->with('success', 'Rute berhasil dihapus');
    }
}
