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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## MBG Tracker Petugas

Petugas dapat membuat akun melalui `/register` sebelum masuk melalui `/login`. Pendaftaran memerlukan nama, email unik, dan kata sandi minimal 8 karakter yang harus dikonfirmasi. Setelah mendaftar, masuk menggunakan email dan kata sandi tersebut.

Kata sandi akan di-hash otomatis oleh model pengguna.

### Pengelolaan akun admin

Atur `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` di `.env`. Kata sandi harus
minimal 8 karakter. Setelah migrasi atau mengimpor `database/schema.sql`, jalankan
seeder dari folder aplikasi:

```bash
php artisan db:seed
```

Seeder membuat akun admin jika belum ada, atau mengaktifkan kembali peran admin
untuk email tersebut. Menjalankannya ulang tidak mengubah nama atau kata sandi
akun yang sudah ada. Jalankan kembali setelah database dibuat ulang. Kredensial
admin tidak disimpan di `schema.sql`.

Admin masuk melalui `/login`. Setelah masuk, tautan **Admin** akan muncul di
dashboard MBG untuk membuka `/admin/users`. Hanya akun admin yang dapat mengelola
akun. Akun admin terakhir dan akun yang sedang digunakan tidak dapat dihapus.

## Menjalankan secara lokal

Pastikan PHP dan Composer tersedia, lalu siapkan database MySQL lokal (misalnya
dari XAMPP). Dari folder `laravel/`:

```bash
composer install
copy .env.example .env
php artisan key:generate
```

Atur `DB_*` di `.env` agar cocok dengan MySQL lokal dan isi `ADMIN_PASSWORD`
(minimal 8 karakter), lalu jalankan:

```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`. File `.env` lokal tidak perlu diganti untuk
menyiapkan konfigurasi hosting.

## Deploy ke hosting dengan document root `htdocs`

Aplikasi membutuhkan PHP **8.3 atau lebih baru**, ekstensi PHP yang diwajibkan
Composer, MySQL/MariaDB, dan Apache dengan `mod_rewrite`. Pastikan versi PHP
hosting memenuhi syarat tersebut sebelum upload.

1. Buat database MySQL dari panel hosting. Di phpMyAdmin, pilih database baru
   yang masih kosong lalu impor `database/schema.sql`. SQL ini sengaja tidak
   membuat atau memilih database karena hosting biasanya sudah membuatnya lewat
   panel.
2. Jalankan `composer install --no-dev --optimize-autoloader` dan `npm run build`
   dari folder aplikasi. Upload **isi** folder `laravel/` ke `htdocs` (bukan
   folder `laravel/` sebagai subfolder), termasuk `vendor/` dan `public/build/`.
   Jangan upload `.env` lokal, `.git/`, atau `node_modules/`.
3. Buat `.env` baru di `htdocs` pada server. Atur `APP_ENV=production`,
   `APP_DEBUG=false`, `APP_URL` ke alamat situs, `APP_KEY` yang unik, dan semua
   nilai `DB_*` sesuai persis dengan informasi database di panel hosting.
   Atur juga `ADMIN_NAME`, `ADMIN_EMAIL`, dan kata sandi admin yang kuat.
4. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis oleh PHP. Jalankan
   `php artisan storage:link` dan `php artisan db:seed` jika hosting menyediakan
   akses perintah Artisan. Jika symlink tidak diizinkan, `.htaccess` tetap
   melayani berkas publik dari `storage/app/public`.

`index.php` dan `.htaccess` di folder aplikasi menjadi pintu masuk ketika isi
folder diunggah langsung ke `htdocs`; keduanya tidak mengubah cara menjalankan
aplikasi lokal melalui `php artisan serve`. Konfigurasi ini menjaga direktori
kode dan dependensi tidak dapat dibuka langsung melalui web. Jika hosting
menyediakan direktori di luar `htdocs`, menyimpan kode aplikasi di luar document
root dan hanya menempatkan berkas `public/` di `htdocs` tetap menjadi pilihan
yang lebih aman.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
