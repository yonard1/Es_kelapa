<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('material.index', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
        ]);

        Material::create($request->all());
        return redirect()->route('material.index')->with('success', 'Bahan berhasil ditambahkan!');
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
        ]);

        $material->update($request->all());
        return redirect()->route('material.index')->with('success', 'Bahan berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('material.index')->with('success', 'Bahan berhasil dihapus!');
    }
}
