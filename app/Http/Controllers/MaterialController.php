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

    public function create(){
        return view('material.modal_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_bahan', 'stok', 'satuan', 'harga']);

        if($request->hasFile('foto')){
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('upload/material'), $filename);
            $data['foto'] = $filename;
        }

        Material::create($data);

        return redirect()->route('material.index')->with('success', 'Bahan berhasil ditambahkan!');
    }

    public function update(Request $request, Material $material)
    {
        // Validasi input
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
        ]);

        // Ambil data input selain gambar
        $data = $request->only(['nama_bahan', 'stok', 'satuan', 'harga']);

        // Jika ada gambar baru yang di-upload
        if ($request->hasFile('foto')) {
            // Periksa apakah file gambar lama ada dan hapus
            if ($material->foto && file_exists(public_path('upload/material/' . $material->foto))) {
                unlink(public_path('upload/material/' . $material->foto));  // Hapus file gambar lama
            }

            // Unggah gambar baru
            $filename = time() . '.' . $request->foto->extension(); // Buat nama file baru dengan timestamp
            $request->foto->move(public_path('upload/material'), $filename);  // Pindahkan file ke folder upload/material
            $data['foto'] = $filename;  // Simpan nama file baru ke dalam data
        }

        // Perbarui data material
        $material->update($data);

        // Kembalikan response dengan pesan sukses
        return redirect()->route('material.index')->with('success', 'Bahan berhasil diperbarui!');
    }

    public function destroy(Material $material)
    {
        if($material->foto && file_exists(public_path('upload/material/'.$material->foto))){
            unlink(public_path('upload/material/'.$material->foto));
        }
        $material->delete();
        return redirect()->route('material.index')->with('success', 'Bahan berhasil dihapus!');
    }
}
