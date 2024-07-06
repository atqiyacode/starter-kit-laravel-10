<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Baris-baris bahasa untuk autentifikasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan selama proses autentifikasi untuk beberapa
    | pesan yang perlu kita tampilkan ke pengguna. Anda bebas untuk memodifikasi
    | baris bahasa sesuai dengan keperluan aplikasi anda.
    |
    */

    'unauthorizedAccount'   => 'Akun tidak valid, Silahkan Masuk',
    'accountNotFound'   => 'Akun Tidak Ditemukan.',
    'failed'   => 'Identitas tersebut tidak cocok dengan data kami.',
    'throttle' => 'Terlalu banyak upaya masuk. Silahkan coba lagi dalam :seconds detik.',
    'password' => 'Kata Sandi Salah.',
    'deleted_user' => 'Akun Anda di bekukan, Silahkan hubungi admin.',
    'wrong_verification_code' => 'Kode verifikasi salah.',
    'wrong_old_password' => 'Kata sandi lama salah.',
    'nik_not_match' => 'NIK KTP tidak cocok dengan Kode Karyawan.',

    'success' => [
        'login' => 'Hallo :name',
        '2fa' => 'Verifikasi Kode OTP',
        'login-text' => 'Selamat Datang di ' . env('APP_NAME') . ' Payroll App',
        'register' => 'Pendaftaran Akun Anda Berhasil.',
        'logout' => 'Kamu sudah keluar dari akunmu.',
        '2fa-text-login' => 'Mohon Masukkan Kode OTP untuk verifikasi',

        'account-verify' => 'Verifikasi',
        '2fa-text' => 'Mohon periksa kode OTP di :method anda',

    ],
];
