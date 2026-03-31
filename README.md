# 📖 Aplikasi Penilaian Tashih Al-Qur'an

Sistem manajemen penilaian ujian baca-tulis Al-Qur'an berbasis web dengan fitur multi-role (Admin, Lembaga, Penguji), export PDF, export Excel, dan log aktivitas.

---

## 🎯 **Fitur Utama**

### **Admin**
- ✅ Manajemen lembaga, penguji, materi ujian, dan item penilaian
- ✅ Manajemen data peserta ujian
- ✅ Penugasan penguji ke materi tertentu
- ✅ Edit nilai peserta
- ✅ Cetak kartu nilai, rekap per lembaga, rekap keseluruhan (PDF)
- ✅ Export data peserta ke Excel
- ✅ Log aktivitas sistem

### **Lembaga**
- ✅ Manajemen data peserta (CRUD)
- ✅ Filter & pencarian peserta
- ✅ Lihat rekap nilai peserta

### **Penguji**
- ✅ Input nilai peserta sesuai materi yang ditugaskan
- ✅ Finalisasi nilai (sekali simpan, tidak bisa diubah)
- ✅ Filter & pencarian peserta
- ✅ Lihat status penilaian

### **Fitur Umum**
- ✅ Sistem autentikasi & role-based access control (Spatie Permission)
- ✅ Dashboard berbeda per role
- ✅ Perhitungan nilai akhir otomatis dengan bobot materi
- ✅ Predikat otomatis (Mumtaz, Jayyid Jiddan, Jayyid, Maqbul, Dhaif)
- ✅ Generate nomor sertifikat otomatis
- ✅ Status penilaian detail (Belum Dinilai, Sedang Dinilai, Lengkap)
- ✅ Tooltip detail penilaian per materi
- ✅ UI/UX Islami dengan warna hijau & emas

---

## 🛠️ **Tech Stack**

- **Backend:** Laravel 12 (PHP 8.4)
- **Frontend:** Blade Templates + Tailwind CSS
- **Database:** MySQL 8.0
- **Auth:** Laravel Breeze + Spatie Permission
- **PDF:** barryvdh/laravel-dompdf
- **Excel:** maatwebsite/laravel-excel
- **Server:** Laravel Valet / Apache / Nginx

---

## 📋 **Requirements**

Pastikan sistem kamu sudah terinstall:

- **PHP >= 8.2** (disarankan 8.4)
- **Composer >= 2.0**
- **MySQL >= 8.0** atau MariaDB >= 10.3
- **Node.js >= 18** dan NPM
- **Git**

---

## 🚀 **Instalasi**

### **1. Clone Repository**
```bash
git clone https://github.com/username/tashih-app.git
cd tashih-app
```

### **2. Install Dependencies**
```bash
composer install
npm install
```

### **3. Setup Environment**

Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### **4. Konfigurasi Database**

Edit file `.env` dan sesuaikan dengan database kamu:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tashih_app
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **5. Buat Database**

Buka MySQL dan buat database:
```bash
sudo mysql -u root -p
```
```sql
CREATE DATABASE tashih_app;
EXIT;
```

### **6. Jalankan Migration & Seeder**
```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat 13 tabel database
- Membuat 3 role (Admin, Lembaga, Penguji)
- Membuat 3 user contoh
- Membuat 1 lembaga contoh
- Membuat 10 materi ujian default dengan item penilaian
- Membuat 10 penguji (masing-masing untuk 1 materi)

### **7. Build Assets**
```bash
npm run build
```

### **8. Jalankan Server**
```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://127.0.0.1:8000**

---

## 👤 **Akun Default**

Setelah seeder berjalan, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@tashih.com | password123 |
| **Lembaga** | lembaga@tashih.com | password123 |
| **Penguji 1** | penguji1@tashih.com | password123 |
| **Penguji 2** | penguji2@tashih.com | password123 |
| **Penguji 3-10** | penguji{3-10}@tashih.com | password123 |

---

## 📁 **Struktur Database**

### **Tabel Utama:**
- `users` — Data user (admin, lembaga, penguji)
- `lembaga` — Data lembaga/institusi
- `peserta` — Data peserta ujian
- `materi` — Materi ujian (Fashohah, Tajwid, dll)
- `item_materi` — Item penilaian per materi
- `nilai` — Nilai peserta per item
- `sertifikat` — Data sertifikat yang diterbitkan
- `penguji_materi` — Relasi penugasan penguji ke materi
- `activity_log` — Log aktivitas sistem
- `notifikasi` — Notifikasi untuk user

---

## 🎨 **Desain UI**

### **Warna Utama:**
- Hijau: `#1B6B3A`
- Emas: `#C9A84C`
- Krem: `#FAF7F2`

### **Font:**
- Inter (Google Fonts)

---

## 📊 **Perhitungan Nilai**

### **Formula Nilai Akhir:**
```
Nilai Materi = (Σ Nilai Item / Σ Nilai Maks Item) × 100
Nilai Akhir = Σ (Nilai Materi × Bobot Materi) / Σ Bobot Materi
```

### **Predikat:**
- **Mumtaz** (ممتاز): ≥ 90
- **Jayyid Jiddan** (جيد جداً): 80-89
- **Jayyid** (جيد): 70-79
- **Maqbul** (مقبول): 60-69
- **Dhaif** (ضعيف): < 60

### **Status Nilai:**
- **Belum Dinilai**: Tidak ada nilai yang diinput
- **Sedang Dinilai**: Sebagian item sudah dinilai
- **Lengkap**: Semua item sudah dinilai

---

## 🔧 **Troubleshooting**

### **Error: Permission denied (storage/logs)**
```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### **Error: Table 'xxx' doesn't exist**

Pastikan semua migration sudah dijalankan:
```bash
php artisan migrate:fresh --seed
```

### **Error: Class "Spatie\Permission\PermissionServiceProvider" not found**

Install ulang dependencies:
```bash
composer install
php artisan optimize:clear
```

### **Error: Vite manifest not found**

Build ulang assets:
```bash
npm install
npm run build
```

---

## 🗂️ **Struktur Folder Penting**
```
tashih-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller admin
│   │   ├── Lembaga/        # Controller lembaga
│   │   └── Penguji/        # Controller penguji
│   ├── Models/             # Eloquent models
│   ├── Helpers/            # Helper functions
│   └── Exports/            # Export Excel classes
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── resources/
│   └── views/
│       ├── admin/          # Views admin
│       ├── lembaga/        # Views lembaga
│       ├── penguji/        # Views penguji
│       ├── layouts/        # Layout templates
│       └── components/     # Blade components
├── routes/
│   └── web.php             # Route definitions
└── public/
    └── templates/          # Template Excel untuk import
```

---

## 🚀 **Deploy (Coming Soon)**

Panduan deploy ke:
- Railway
- Vercel
- VPS (Apache/Nginx)

---

## 📝 **Changelog**

### **v1.0.0 (Current)**
- ✅ Sistem autentikasi & role management
- ✅ CRUD master data (lembaga, penguji, materi, peserta)
- ✅ Input & edit nilai
- ✅ Export PDF & Excel
- ✅ Log aktivitas
- ✅ Penugasan penguji ke materi
- ✅ Status penilaian detail dengan tooltip
- ✅ Filter & pencarian peserta
- ✅ Data orang tua peserta (nama ayah & ibu)

### **v1.1.0 (Planned)**
- ⏳ Import batch peserta via Excel
- ⏳ Periode ujian Hijriyah + Masehi
- ⏳ Notifikasi in-app & email
- ⏳ Deploy to production

---

## 📄 **License**

MIT License - Bebas digunakan untuk keperluan pendidikan dan komersial.

---

## 📞 **Support**

Jika ada pertanyaan atau butuh bantuan:
- Email: admin@tashih.com
- GitHub Issues: [Create Issue](https://github.com/username/tashih-app/issues)

---

**Dibuat dengan ❤️ untuk pendidikan Al-Qur'an**
