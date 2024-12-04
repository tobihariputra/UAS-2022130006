<?php

namespace App\Http\Controllers;

use App\Models\Stasiun;
use Illuminate\Http\Request;

class StasiunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stasiuns = Stasiun::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Stasiun', 'url' => route('stasiuns.index')],
        ];
        return view('stasiuns.index', compact('stasiuns', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Stasiun', 'url' => route('stasiuns.index')],
            ['name' => 'Tambah Stasiun'],
        ];
        return view('stasiuns.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_stasiun' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
        ]);

        Stasiun::create($request->all());
        return redirect()->route('stasiuns.index')->with('success', 'Stasiun berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stasiun $stasiun)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Stasiun', 'url' => route('stasiuns.index')],
            ['name' => 'Edit Stasiun'],
        ];
        return view('stasiuns.edit', compact('stasiun', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stasiun $stasiun)
    {
        $request->validate([
            'nama_stasiun' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
        ]);

        $stasiun->update($request->all());
        return redirect()->route('stasiuns.index')->with('success', 'Stasiun berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stasiun $stasiun)
    {
        $stasiun->delete();
        return redirect()->route('stasiuns.index')->with('success', 'Stasiun berhasil dihapus');
    }
}
