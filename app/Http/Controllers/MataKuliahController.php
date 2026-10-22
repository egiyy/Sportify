<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;

class MataKuliahController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'List Mata Kuliah',
            'mks' => MataKuliah::all(),
        ];
        return view('list_mk', $data);
    }

    public function create()
    {
        return view('create_mk', ['title' => 'Create Mata Kuliah']);
    }

    public function store(Request $request)
    {
        MataKuliah::create([
            'nama_mk' => $request->input('nama_mk'),
            'sks' => $request->input('sks'),
        ]);

        return redirect()->to('/matakuliah');
    }

    public function edit($id)
    {
    $mk = MataKuliah::findOrFail($id);
    return view('edit_mk', ['title' => 'Edit Mata Kuliah', 'mk' => $mk]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mk' => 'required',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $mk = MataKuliah::findOrFail($id);
        $mk->update([
            'nama_mk' => $request->input('nama_mk'),
            'sks' => $request->input('sks'),
        ]);

        return redirect()->to('/matakuliah')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $mk = MataKuliah::findOrFail($id);
        $mk->delete();

        return redirect()->to('/matakuliah')->with('success', 'Data berhasil dihapus!');
    }
}