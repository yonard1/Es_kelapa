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
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek apakah bahan dengan nama yang sama sudah ada
        $existing = Material::where('nama_bahan', $request->nama_bahan)->first();

        if ($existing) {
            // Kalau sudah ada, jangan tambah stok — tampilkan pesan error
            return redirect()->back()->withErrors([
                'nama_bahan' => 'Bahan dengan nama tersebut sudah terdaftar!',
            ])->withInput(); // biar input sebelumnya nggak hilang
        }

        // Kalau belum ada, simpan data baru
        $material = new Material();
        $material->nama_bahan = $request->nama_bahan;
        $material->stok = $request->stok;
        $material->satuan = $request->satuan;
        $material->harga = $request->harga;

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/material'), $filename);
            $material->foto = $filename;
        }

        $material->save();

        return redirect()->back()->with('success', 'Bahan baru berhasil ditambahkan!');
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
