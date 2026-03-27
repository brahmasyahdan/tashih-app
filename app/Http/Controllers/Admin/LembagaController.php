<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        $lembaga = Lembaga::latest()->paginate(10);
        return view('admin.lembaga.index', compact('lembaga'));
    }

    public function create()
    {
        return view('admin.lembaga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'kode_lembaga' => 'required|string|max:10|unique:lembaga,kode_lembaga',
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'email'        => 'nullable|email',
            'nama_kepala'  => 'nullable|string|max:255',
        ]);

        Lembaga::create($request->all());

        return redirect()->route('admin.lembaga.index')
                         ->with('success', 'Lembaga berhasil ditambahkan!');
    }

    public function edit(Lembaga $lembaga)
    {
        return view('admin.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, Lembaga $lembaga)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'kode_lembaga' => 'required|string|max:10|unique:lembaga,kode_lembaga,' . $lembaga->id,
            'alamat'       => 'nullable|string',
            'telepon'      => 'nullable|string|max:20',
            'email'        => 'nullable|email',
            'nama_kepala'  => 'nullable|string|max:255',
        ]);

        $lembaga->update($request->all());

        return redirect()->route('admin.lembaga.index')
                         ->with('success', 'Lembaga berhasil diperbarui!');
    }

    public function destroy(Lembaga $lembaga)
    {
        $lembaga->delete();
        return redirect()->route('admin.lembaga.index')
                         ->with('success', 'Lembaga berhasil dihapus!');
    }
}