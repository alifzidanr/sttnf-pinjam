# Sistem Reservasi Ruangan STTNF

Proyek GitHub ini merinci pembangunan aplikasi reservasi ruangan kampus berdasarkan permintaan dari Badan Sarana dan Prasarana STTNF. Aplikasi dibuat menggunakan framework Laravel dengan template QuickAdminPanel dan beberapa plugin. Proyek ini mengikuti metodologi Rational Unified Process (RUP) untuk dokumentasi, memastikan pendekatan pengembangan perangkat lunak yang sistematis dan terstruktur. Aplikasi bertujuan untuk menyederhanakan proses reservasi ruangan kampus, meningkatkan efisiensi Badan Sarana dan Prasarana STTNF.

## Cara Penggunaan

```bash
# 1. Kloning repository
git clone <repository-url>

# 2. Salin file .env.example ke .env dan edit credential database di sana.
cp .env.example .env

# 3. Jalankan composer install.
composer install

# 4. Jalankan php artisan key:generate.
php artisan key:generate

# 5. Jalankan php artisan migrate untuk menjalankan migrasi database.
php artisan migrate

# 6. Jalankan php artisan migrate --seed untuk mengimport seed data untuk login ke sistem.
php artisan migrate --seed

# 7. Jalankan URL utama dengan php artisan serve.
php artisan serve
