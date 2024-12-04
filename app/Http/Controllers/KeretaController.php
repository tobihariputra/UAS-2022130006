<?php

namespace App\Http\Controllers;

use App\Models\Kereta;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keretas = Kereta::all();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Kereta', 'url' => route('keretas.index')],
        ];
        return view('keretas.index', compact('keretas', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Kereta', 'url' => route('keretas.index')],
            ['name' => 'Tambah Kereta'],
        ];

        return view('keretas.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kereta' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        Kereta::create($request->all());
        return redirect()->route('keretas.index')->with('success', 'Kereta berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kereta $kereta)
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('admin.dashboard')],
            ['name' => 'Kelola Kereta', 'url' => route('keretas.index')],
            ['name' => 'Edit Kereta'],
        ];

        return view('keretas.edit', compact('kereta', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kereta $kereta)
    {
        $request->validate([
            'nama_kereta' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
        ]);

        $kereta->update($request->all());
        return redirect()->route('keretas.index')->with('success', 'Kereta berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kereta $kereta)
    {
        $kereta->delete();
        return redirect()->route('keretas.index')->with('success', 'Kereta berhasil dihapus');
    }
}
