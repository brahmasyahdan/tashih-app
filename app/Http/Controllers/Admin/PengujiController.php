<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengujiController extends Controller
{
    public function index()
    {
        $penguji = User::role('penguji')->latest()->paginate(10);
        return view('admin.penguji.index', compact('penguji'));
    }

    public function create()
    {
        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.penguji.create', compact('materi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8|confirmed',
            'telepon'     => 'nullable|string|max:20',
            'materi_ids'  => 'required|array|min:1',
            'materi_ids.*'=> 'exists:materi,id',
        ], [
            'materi_ids.required' => 'Pilih minimal 1 materi yang ditugaskan',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'telepon'  => $request->telepon,
        ]);

        $user->assignRole('penguji');
        
        // Attach materi yang ditugaskan
        $user->materiYangDiuji()->attach($request->materi_ids);

        return redirect()->route('admin.penguji.index')
                        ->with('success', 'Penguji berhasil ditambahkan dengan penugasan materi!');
    }

    public function edit(User $penguji)
    {
        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();
        return view('admin.penguji.edit', compact('penguji', 'materi'));
    }

    public function update(Request $request, User $penguji)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $penguji->id,
            'telepon'     => 'nullable|string|max:20',
            'materi_ids'  => 'required|array|min:1',
            'materi_ids.*'=> 'exists:materi,id',
        ], [
            'materi_ids.required' => 'Pilih minimal 1 materi yang ditugaskan',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'telepon' => $request->telepon,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $penguji->update($data);
        
        // Sync materi yang ditugaskan (hapus lama, tambah baru)
        $penguji->materiYangDiuji()->sync($request->materi_ids);

        return redirect()->route('admin.penguji.index')
                        ->with('success', 'Data penguji berhasil diperbarui!');
    }

    public function destroy(User $penguji)
    {
        $penguji->delete();
        return redirect()->route('admin.penguji.index')
                         ->with('success', 'Penguji berhasil dihapus!');
    }
}