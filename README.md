# FoodBridge — Dashboard "Klaim Masuk"

Mockup UI dashboard berbasis **Laravel 12** (Blade + CSS murni, tanpa framework CSS dan tanpa build step Vite/npm).

## Menjalankan

PHP yang dipakai adalah PHP 8.4 portable di Laragon (belum masuk PATH):

```powershell
$env:Path = "C:\laragon\bin\php\php-8.4.27-nts;" + $env:Path
cd "C:\Users\HYPE AMD\Documents\PPL"

php artisan migrate:fresh --seed
php artisan serve
```

Buka http://127.0.0.1:8080

## Struktur utama

| File | Keterangan |
| --- | --- |
| `routes/web.php` | Route `/` dan `/klaim-masuk` |
| `app/Http/Controllers/ClaimController.php` | Query data, filter, dan statistik |
| `app/Models/Claim.php` | Model + konstanta status/metode + accessor label |
| `database/migrations/*_create_claims_table.php` | Skema tabel `claims` |
| `database/seeders/ClaimSeeder.php` | 6 data klaim sesuai desain |
| `config/foodbridge.php` | Profil pengguna, instansi, dan menu sidebar |
| `resources/views/layouts/app.blade.php` | Layout utama |
| `resources/views/partials/sidebar.blade.php` | Sidebar + kartu profil |
| `resources/views/partials/header.blade.php` | Breadcrumb, sapaan, aksi kanan |
| `resources/views/claims/index.blade.php` | Statistik, filter, tabel, pagination |
| `resources/views/components/icon.blade.php` | Kumpulan ikon SVG inline |
| `resources/views/components/status-badge.blade.php` | Badge status (Menunggu/Disetujui/Selesai/Ditolak) |
| `public/css/dashboard.css` | Seluruh styling (tema forest green) |

## Filter yang berfungsi

Form filter memakai query string dan diproses di controller:

- `?q=nasi` — cari nama makanan / penerima
- `?status=menunggu` — `menunggu`, `disetujui`, `selesai`, `ditolak`
- `?method=kurir_online` — `ambil_sendiri`, `kurir_online`
- Bisa digabung, contoh: `/?status=menunggu&method=ambil_sendiri`

## Tes

```powershell
php artisan test
```

6 tes lulus: render halaman, ringkasan statistik, filter status, pencarian, dan filter metode.

## Catatan

- Angka pagination (`6 dari 18`, `Halaman 1 dari 10`) ditulis sesuai copy desain, sementara isi tabel diambil dari database (6 baris). Jika nanti memakai pagination nyata, ganti nilai pada `$pagination` di `ClaimController`.
- Font Inter dimuat dari Google Fonts; tanpa internet akan jatuh ke Segoe UI/Roboto.
