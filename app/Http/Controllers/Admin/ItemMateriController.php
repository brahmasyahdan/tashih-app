<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\ItemMateri;
use Illuminate\Http\Request;

class ItemMateriController extends Controller
{
    public function index(Materi $materi)
    {
        $items = $materi->itemMateri()->orderBy('urutan')->paginate(15);
        return view('admin.item-materi.index', compact('materi', 'items'));
    }

    public function create(Materi $materi)
    {
        return view('admin.item-materi.create', compact('materi'));
    }

    public function store(Request $request, Materi $materi)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'nilai_max' => 'required|numeric|min:0|max:100',
            'urutan'    => 'required|integer|min:1',
        ]);

        $materi->itemMateri()->create($request->all());

        return redirect()->route('admin.materi.item.index', $materi)
                         ->with('success', 'Item materi berhasil ditambahkan!');
    }

    public function edit(Materi $materi, ItemMateri $item)
    {
        return view('admin.item-materi.edit', compact('materi', 'item'));
    }

    public function update(Request $request, Materi $materi, ItemMateri $item)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'nilai_max' => 'required|numeric|min:0|max:100',
            'urutan'    => 'required|integer|min:1',
        ]);

        $item->update($request->all());

        return redirect()->route('admin.materi.item.index', $materi)
                         ->with('success', 'Item materi berhasil diperbarui!');
    }

    public function destroy(Materi $materi, ItemMateri $item)
    {
        $item->delete();
        return redirect()->route('admin.materi.item.index', $materi)
                         ->with('success', 'Item materi berhasil dihapus!');
    }
}