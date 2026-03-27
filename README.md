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

## 👥 **Kontributor**

- **Developer:** [Your Name]
- **Design:** [Your Name]

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




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
