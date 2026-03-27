<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    // Ambil lembaga_id dari user yang login
    private function getLembagaId(): int
    {
        return Auth::user()->lembaga_id;
    }

    public function index(Request $request)
    {
        // Ambil lembaga_id user yang login dengan aman
        $lembagaId = Auth::user()->lembaga_id;
        
        // Validasi: pastikan user punya lembaga_id
        if (!$lembagaId) {
            return redirect()->route('dashboard')
                            ->with('error', 'Anda belum terdaftar di lembaga manapun. Hubungi admin.');
        }

        $query = Peserta::where('lembaga_id', $lembagaId)
                        ->with('lembaga')
                        ->latest();

        // Filter pencarian by nama peserta
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_peserta', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by tahun ujian
        if ($request->filled('tahun_ujian')) {
            $query->where('tahun_ujian', $request->tahun_ujian);
        }

        // Filter by predikat
        if ($request->filled('predikat')) {
            $query->where('predikat', $request->predikat);
        }

        $peserta = $query->paginate(15)->withQueryString();

        // Ambil daftar tahun untuk filter
        $tahunList = Peserta::where('lembaga_id', $lembagaId)
                            ->distinct()
                            ->pluck('tahun_ujian')
                            ->sort()
                            ->values();

        return view('lembaga.peserta.index', compact('peserta', 'tahunList'));
    }

    public function create()
    {
        return view('lembaga.peserta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peserta'  => 'required|string|max:255',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'nis'           => 'nullable|string|max:30',
            'jenis_kelamin' => 'required|in:L,P',
            'tahun_ujian'   => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        Peserta::create(array_merge(
            $request->all(),
            ['lembaga_id' => $this->getLembagaId()]
        ));

        \App\Helpers\TashihHelper::logActivity('Tambah Murid', "Menambah murid: {$request->nama_peserta}");

        return redirect()->route('lembaga.peserta.index')
                         ->with('success', 'Data murid berhasil ditambahkan!');
    }

    public function edit(Peserta $peserta)
    {
        // Pastikan peserta milik lembaga ini
        abort_if($peserta->lembaga_id !== $this->getLembagaId(), 403);
        return view('lembaga.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        abort_if($peserta->lembaga_id !== $this->getLembagaId(), 403);

        $request->validate([
            'nama_peserta'  => 'required|string|max:255',
            'nama_ayah'     => 'nullable|string|max:255',
            'nama_ibu'      => 'nullable|string|max:255',
            'nis'           => 'nullable|string|max:30',
            'jenis_kelamin' => 'required|in:L,P',
            'tahun_ujian'   => 'required|digits:4',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
        ]);

        $peserta->update($request->all());

        \App\Helpers\TashihHelper::logActivity('Edit Murid', "Mengedit murid: {$peserta->nama_peserta} (ID: {$peserta->id})");

        return redirect()->route('lembaga.peserta.index')
                         ->with('success', 'Data murid berhasil diperbarui!');
    }

    public function destroy(Peserta $peserta)
    {
        abort_if($peserta->lembaga_id !== $this->getLembagaId(), 403);
        $nama = $peserta->nama_peserta;
        $peserta->delete();
        \App\Helpers\TashihHelper::logActivity('Hapus Murid', "Menghapus murid: {$nama}");
        return redirect()->route('lembaga.peserta.index')
                         ->with('success', 'Data murid berhasil dihapus!');
    }
}