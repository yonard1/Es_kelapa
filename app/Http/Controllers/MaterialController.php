<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::paginate(10);
        return view('material.index', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🔍 Cek duplikat nama bahan
        if (Material::where('nama_bahan', $request->nama_bahan)->exists()) {
            return redirect()->back()->with('error', 'Bahan dengan nama tersebut sudah ada!');
        }

        $data = $request->only(['nama_bahan', 'stok', 'satuan', 'harga']);

        if ($request->hasFile('foto')) {
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/material'), $filename);
            $data['foto'] = $filename;
        }

        Material::create($data);

        return redirect()->route('material.index')->with('success', 'Bahan baru berhasil ditambahkan!');
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🔍 Cek duplikat nama bahan selain dirinya sendiri
        $cekNama = Material::where('nama_bahan', $request->nama_bahan)
                            ->where('id_bahan', '!=', $material->id_bahan)
                            ->exists();

        if ($cekNama) {
            return redirect()->back()->with('error', 'Nama bahan sudah digunakan oleh bahan lain!');
        }

        $data = $request->only(['nama_bahan', 'stok', 'satuan', 'harga']);

        if ($request->hasFile('foto')) {
            if ($material->foto && file_exists(public_path('upload/material/' . $material->foto))) {
                unlink(public_path('upload/material/' . $material->foto));
            }

            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/material'), $filename);
            $data['foto'] = $filename;
        }

        $material->update($data);

        return redirect()->route('material.index')->with('success', 'Bahan berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        if ($material->foto && file_exists(public_path('upload/material/' . $material->foto))) {
            unlink(public_path('upload/material/' . $material->foto));
        }

        $material->delete();

        return redirect()->route('material.index')->with('success', 'Bahan berhasil dihapus!');
    }
}
