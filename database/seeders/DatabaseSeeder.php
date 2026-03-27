<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Lembaga;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat role
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleLembaga = Role::firstOrCreate(['name' => 'lembaga', 'guard_name' => 'web']);
        $rolePenguji = Role::firstOrCreate(['name' => 'penguji', 'guard_name' => 'web']);

        // Buat lembaga contoh
        $lembaga = Lembaga::firstOrCreate(
            ['kode_lembaga' => 'LBG01'],
            [
                'nama_lembaga' => 'Lembaga Contoh',
                'alamat'       => 'Jl. Contoh No. 1',
                'email'        => 'lembaga@contoh.com',
            ]
        );

        // Buat user Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@tashih.com'],
            [
                'name'     => 'Admin Tashih',
                'password' => Hash::make('password123'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Buat user Lembaga
        $userLembaga = User::firstOrCreate(
            ['email' => 'lembaga@tashih.com'],
            [
                'name'       => 'User Lembaga',
                'password'   => Hash::make('password123'),
                'lembaga_id' => $lembaga->id,
            ]
        );
        if (!$userLembaga->hasRole('lembaga')) {
            $userLembaga->assignRole('lembaga');
        }

        // Panggil MateriSeeder dulu agar materi sudah ada
        $this->call(MateriSeeder::class);

        // Buat 10 Penguji - masing-masing untuk 1 materi
        $namaMateri = [
            1 => 'Fashohah',
            2 => 'Tajwid',
            3 => 'Ghorib & Musykilat',
            4 => 'Suara & Lagu',
            5 => 'Hafalan (Tahfidz)',
            6 => 'Tulis Al-Qur\'an',
            7 => 'Adab Membaca',
            8 => 'Pemahaman (Tafsir Dasar)',
            9 => 'Shorof & Nahwu',
            10 => 'Do\'a & Praktik Ibadah',
        ];

        foreach ($namaMateri as $materiId => $namaM) {
            $penguji = User::firstOrCreate(
                ['email' => 'penguji' . $materiId . '@tashih.com'],
                [
                    'name'     => 'Penguji ' . $namaM,
                    'password' => Hash::make('password123'),
                    'telepon'  => '081234567' . str_pad($materiId, 3, '0', STR_PAD_LEFT),
                ]
            );
            
            if (!$penguji->hasRole('penguji')) {
                $penguji->assignRole('penguji');
            }

            // Assign ke materi yang sesuai
            $penguji->materiYangDiuji()->syncWithoutDetaching([$materiId]);
        }
    }
}