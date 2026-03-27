<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\ItemMateri;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Fashohah', 'items' => ['Tartil', 'Kelancaran', 'Makhroj Huruf', 'Sifatul Huruf', 'Mad wal Qasr']],
            ['nama' => 'Tajwid', 'items' => ['Hukum Nun Sukun/Tanwin', 'Hukum Mim Sukun', 'Hukum Mad', 'Hukum Waqaf']],
            ['nama' => 'Ghorib & Musykilat', 'items' => ['Imalah', 'Isymam', 'Tashil', 'Naql', 'Saktah']],
            ['nama' => 'Suara & Lagu', 'items' => ['Keindahan Suara', 'Kesesuaian Lagu', 'Variasi Lagu']],
            ['nama' => 'Hafalan (Tahfidz)', 'items' => ['Kelancaran Hafalan', 'Ketepatan Ayat', 'Urutan Surat']],
            ['nama' => 'Tulis Al-Qur\'an', 'items' => ['Kerapian Tulisan', 'Ketepatan Kaidah', 'Kelengkapan Harokat']],
            ['nama' => 'Adab Membaca', 'items' => ['Adab Sebelum Membaca', 'Sikap Duduk', 'Kesopanan']],
            ['nama' => 'Pemahaman (Tafsir Dasar)', 'items' => ['Pemahaman Arti', 'Pemahaman Kandungan']],
            ['nama' => 'Shorof & Nahwu', 'items' => ['Identifikasi Kata', 'Struktur Kalimat']],
            ['nama' => 'Do\'a & Praktik Ibadah', 'items' => ['Ketepatan Bacaan', 'Urutan & Kelengkapan']],
        ];

        foreach ($data as $urutan => $item) {
            $materi = Materi::create([
                'nama_materi' => $item['nama'],
                'urutan'      => $urutan + 1,
                'bobot'       => 10.00,
                'is_active'   => true,
            ]);

            foreach ($item['items'] as $i => $namaItem) {
                ItemMateri::create([
                    'materi_id' => $materi->id,
                    'nama_item' => $namaItem,
                    'nilai_max' => 100,
                    'urutan'    => $i + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}