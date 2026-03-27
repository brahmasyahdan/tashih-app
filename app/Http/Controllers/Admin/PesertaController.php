<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Lembaga;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('lembaga')->latest();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_peserta', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('lembaga_id')) {
            $query->where('lembaga_id', $request->lembaga_id);
        }

        if ($request->filled('tahun_ujian')) {
            $query->where('tahun_ujian', $request->tahun_ujian);
        }

        if ($request->filled('predikat')) {
            $query->where('predikat', $request->predikat);
        }

        $peserta  = $query->paginate(15)->withQueryString();
        $lembaga  = Lembaga::orderBy('nama_lembaga')->get();
        $tahunList = Peserta::selectRaw('DISTINCT tahun_ujian')
                            ->orderByDesc('tahun_ujian')->pluck('tahun_ujian');

        return view('admin.peserta.index', compact('peserta', 'lembaga', 'tahunList'));
    }

    public function create()
    {
        $lembaga = Lembaga::where('is_active', true)->orderBy('nama_lembaga')->get();
        return view('admin.peserta.create', compact('lembaga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peserta'  => 'required|string|max:255',
            'lembaga_id'    => 'required|exists:lembaga,id',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'nis'           => 'nullable|string|max:30',
            'jenis_kelamin' => 'required|in:L,P',
            'tahun_ujian'   => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        Peserta::create($request->all());

        \App\Helpers\TashihHelper::logActivity('Tambah Peserta', "Menambah peserta: {$request->nama_peserta}");

        return redirect()->route('admin.peserta.index')
                         ->with('success', 'Data peserta berhasil ditambahkan!');
    }

    public function edit(Peserta $peserta)
    {
        $lembaga = Lembaga::where('is_active', true)->orderBy('nama_lembaga')->get();
        return view('admin.peserta.edit', compact('peserta', 'lembaga'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'nama_peserta'  => 'required|string|max:255',
            'lembaga_id'    => 'required|exists:lembaga,id',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'nis'           => 'nullable|string|max:30',
            'jenis_kelamin' => 'required|in:L,P',
            'tahun_ujian'   => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $peserta->update($request->all());

        \App\Helpers\TashihHelper::logActivity('Edit Peserta', "Mengedit peserta: {$peserta->nama_peserta} (ID: {$peserta->id})");

        return redirect()->route('admin.peserta.index')
                         ->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy(Peserta $peserta)
    {
        $nama = $peserta->nama_peserta;
        $peserta->delete();
        \App\Helpers\TashihHelper::logActivity('Hapus Peserta', "Menghapus peserta: {$nama}");
        return redirect()->route('admin.peserta.index')
                         ->with('success', 'Data peserta berhasil dihapus!');
    }
}