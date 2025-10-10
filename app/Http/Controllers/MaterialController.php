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
        $request->validate([
            'nama_bahan' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_bahan', 'stok', 'satuan', 'harga']);

        if($request->hasFile('foto')){
            if($material->foto && file_exists(public_path('upload/material/'.$material->foto))){
                unlink(public_path('upload/material/'.$material->foto));
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
        if($material->foto && file_exists(public_path('upload/material/'.$material->foto))){
            unlink(public_path('upload/material/'.$material->foto));
        }
        $material->delete();
        return redirect()->route('material.index')->with('success', 'Bahan berhasil dihapus!');
    }
}
