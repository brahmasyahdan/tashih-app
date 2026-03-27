<?php

namespace App\Exports;

use App\Models\Peserta;
use App\Models\Materi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PesertaExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $lembagaId;

    public function __construct($lembagaId = null)
    {
        $this->lembagaId = $lembagaId;
    }

    public function collection()
    {
        $query = Peserta::with(['lembaga', 'sertifikat', 'nilai.itemMateri']);
        
        if ($this->lembagaId) {
            $query->where('lembaga_id', $this->lembagaId);
        }
        
        return $query->orderBy('lembaga_id')->orderBy('nama_peserta')->get();
    }

    public function headings(): array
    {
        $headers = [
            'No',
            'Nama Peserta',
            'NIS',
            'Lembaga',
            'Tahun Ujian',
            'Jenis Kelamin',
        ];

        // Tambahkan header untuk setiap materi
        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();
        foreach ($materi as $m) {
            $headers[] = $m->nama_materi . ' (%)';
        }

        $headers[] = 'Nilai Akhir';
        $headers[] = 'Predikat';
        $headers[] = 'No. Sertifikat';
        $headers[] = 'Status';

        return $headers;
    }

    public function map($peserta): array
    {
        static $no = 0;
        $no++;

        $row = [
            $no,
            $peserta->nama_peserta,
            $peserta->nis ?? '-',
            $peserta->lembaga->nama_lembaga ?? '-',
            $peserta->tahun_ujian,
            $peserta->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
        ];

        // Hitung nilai per materi
        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();
        foreach ($materi as $m) {
            $items = $m->itemMateri()->where('is_active', true)->get();
            if ($items->isEmpty()) {
                $row[] = '-';
                continue;
            }

            $nilaiMateri = 0;
            $jumlahItem = 0;

            foreach ($items as $item) {
                $nilai = $peserta->nilai()
                    ->where('item_materi_id', $item->id)
                    ->first();

                if ($nilai) {
                    $nilaiMateri += ($nilai->nilai / $item->nilai_max) * 100;
                    $jumlahItem++;
                }
            }

            if ($jumlahItem > 0) {
                $row[] = number_format($nilaiMateri / $jumlahItem, 1);
            } else {
                $row[] = '-';
            }
        }

        $row[] = $peserta->nilai_akhir ? number_format($peserta->nilai_akhir, 1) : '-';
        $row[] = $peserta->predikat ?? '-';
        $row[] = $peserta->sertifikat->nomor_sertifikat ?? '-';
        $row[] = $peserta->status_nilai === 'lengkap' ? 'Lengkap' : 'Draft';

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1B6B3A']],
            ],
        ];
    }
}