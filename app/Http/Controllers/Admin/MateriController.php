<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::orderBy('urutan')->paginate(15);
        return view('admin.materi.index', compact('materi'));
    }

    public function create()
    {
        return view('admin.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'urutan'      => 'required|integer|min:1',
            'bobot'       => 'required|numeric|min:0|max:100',
        ]);

        Materi::create($request->all());

        return redirect()->route('admin.materi.index')
                         ->with('success', 'Materi berhasil ditambahkan!');
    }

    public function edit(Materi $materi)
    {
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'nama_materi' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'urutan'      => 'required|integer|min:1',
            'bobot'       => 'required|numeric|min:0|max:100',
        ]);

        $materi->update($request->all());

        return redirect()->route('admin.materi.index')
                         ->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();
        return redirect()->route('admin.materi.index')
                         ->with('success', 'Materi berhasil dihapus!');
    }
}