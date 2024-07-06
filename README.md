# Laravel 10 Starter Kit by atqiyacode

Deskripsi singkat tentang apa yang dilakukan oleh proyek ini.

## Daftar Isi

- [Laravel 10 Starter Kit by atqiyacode](#laravel-10-starter-kit-by-atqiyacode)
  - [Daftar Isi](#daftar-isi)
  - [Fitur](#fitur)
  - [Prasyarat](#prasyarat)
  - [Package](#package)
  - [Instalasi](#instalasi)
  - [Penggunaan](#penggunaan)

## Fitur

- Fitur 1: Deskripsi fitur 1.
- Fitur 2: Deskripsi fitur 2.
- Fitur 3: Deskripsi fitur 3.

## Prasyarat

Sebelum memulai instalasi, pastikan Anda memiliki hal-hal berikut:

- PHP >= 8.2
- Composer
- Database (MySQL, PostgreSQL, dll.)
- Node.js & NPM
  
## Package

- Laravel Passport

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal proyek ini:

1. Clone repositori:

    ```bash
    git clone https://github.com/atqiyacode/atqiyacode-starter-kit.git
    cd atqiyacode-starter-kit
    ```

2. Instal dependensi Composer:

    ```bash
    composer install
    ```

3. Instal dependensi Node.js:

    ```bash
    npm install
    npm run dev
    ```

4. Salin file `.env.example` ke `.env` dan konfigurasi:

    ```bash
    cp .env.example .env
    ```

5. Generate key aplikasi:

    ```bash
    php artisan key:generate
    ```

6. Migrasi dan seeder database:

    ```bash
    php artisan migrate --seed
    ```

7. Storage Link:

    ```bash
    php artisan storage:link
    ```

## Penggunaan

- Untuk menjalankan server pengembangan lokal, gunakan perintah berikut:

 ```bash
 php artisan serve
 ```

- Menajalankan Queue

 ```bash
 php artisan queue:work --memory=2048 --tries=5 --timeout=300
 ```

- Menajalankan Websocket (Laravel Reverb)

 ```bash
 php artisan reverb:start
 ```

-  
