<?php

namespace App\Imports;

use App\Models\Peserta;
use App\Models\Lembaga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PesertaImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    protected $lembagaId;

    public function __construct($lembagaId = null)
    {
        $this->lembagaId = $lembagaId;
    }

    public function model(array $row)
    {
        $lembagaId = $this->lembagaId;

        // Jika admin (tidak ada lembaga_id), cari dari nama lembaga di Excel
        if (!$lembagaId && isset($row['lembaga'])) {
            $lembaga = Lembaga::where('nama_lembaga', $row['lembaga'])->first();
            if (!$lembaga) {
                throw new \Exception("Lembaga '{$row['lembaga']}' tidak ditemukan.");
            }
            $lembagaId = $lembaga->id;
        }

        if (!$lembagaId) {
            throw new \Exception("Lembaga tidak ditemukan.");
        }

        return new Peserta([
            'lembaga_id' => $lembagaId,
            'nama_peserta' => $row['nama_peserta'],
            'nama_ayah' => $row['nama_ayah'] ?? null,
            'nama_ibu' => $row['nama_ibu'] ?? null,
            'nis' => $row['nis'] ?? null,
            'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
            'tempat_lahir' => $row['tempat_lahir'] ?? null,
            'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
            'tahun_ujian' => $row['tahun_ujian'],
            'status_nilai' => 'belum_dinilai',
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_peserta' => 'required|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'nis' => 'nullable|string|max:50|unique:peserta,nis',
            'jenis_kelamin' => 'required|in:L,P,l,p',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'tahun_ujian' => 'required|integer|min:2000|max:2100',
            'lembaga' => $this->lembagaId ? 'nullable' : 'required|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama_peserta.required' => 'Nama peserta wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi (L/P).',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
            'tahun_ujian.required' => 'Tahun ujian wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'lembaga.required' => 'Nama lembaga wajib diisi.',
        ];
    }
}