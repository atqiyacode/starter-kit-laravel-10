<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Halaman Contoh
    |--------------------------------------------------------------------------
    */
    // 'page' => [
    //     'title' => 'Judul Halaman',
    //     'heading' => 'Judul Utama Halaman',
    //     'subheading' => 'Subjudul Halaman',
    //     'navigationLabel' => 'Label Navigasi Halaman',
    //     'section' => [],
    //     'fields' => []
    // ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Umum
    |--------------------------------------------------------------------------
    */
    'general_settings' => [
        'title' => 'Pengaturan Umum',
        'heading' => 'Pengaturan Umum',
        'subheading' => 'Kelola pengaturan umum situs di sini.',
        'navigationLabel' => 'Umum',
        'sections' => [
            'site' => [
                'title' => 'Situs',
                'description' => 'Kelola pengaturan dasar.'
            ],
            'theme' => [
                'title' => 'Tema',
                'description' => 'Ubah tema default.'
            ],
        ],
        'fields' => [
            'brand_name' => 'Nama Merek',
            'site_active' => 'Status Situs',
            'brand_logoHeight' => 'Tinggi Logo Merek',
            'brand_logo' => 'Logo Merek',
            'brand_logo_dark' => 'Logo Merek Gelap',
            'site_favicon' => 'Favicon Situs',
            'primary' => 'Utama',
            'secondary' => 'Sekunder',
            'gray' => 'Abu-abu',
            'success' => 'Berhasil',
            'danger' => 'Bahaya',
            'info' => 'Info',
            'warning' => 'Peringatan',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Email
    |--------------------------------------------------------------------------
    */
    'mail_settings' => [
        'title' => 'Pengaturan Email',
        'heading' => 'Pengaturan Email',
        'subheading' => 'Kelola konfigurasi email.',
        'navigationLabel' => 'Email',
        'sections' => [
            'config' => [
                'title' => 'Konfigurasi',
                'description' => 'Deskripsi'
            ],
            'sender' => [
                'title' => 'Dari (Pengirim)',
                'description' => 'Deskripsi'
            ],
            'mail_to' => [
                'title' => 'Kirim ke',
                'description' => 'Deskripsi'
            ],
        ],
        'fields' => [
            'placeholder' => [
                'receiver_email' => 'Email penerima..'
            ],
            'driver' => 'Driver',
            'host' => 'Host',
            'port' => 'Port',
            'encryption' => 'Enkripsi',
            'timeout' => 'Waktu Habis',
            'username' => 'Nama Pengguna',
            'password' => 'Kata Sandi',
            'email' => 'Email',
            'name' => 'Nama',
            'mail_to' => 'Kirim ke',
        ],
        'actions' => [
            'send_test_mail' => 'Kirim Email Uji'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Table Page
    |--------------------------------------------------------------------------
    */
    'status' => [
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
        'yes' => 'Terdaftar',
        'no' => 'Tidak Terdaftar',
        'running' => 'Berjalan',
        'ended' => 'Berakhir',
        'document_yes' => 'Lengkap',
        'document_no' => 'Belum Lengkap',
        'document_count' => 'Dokumen',
    ],

    'table' => [
        'no_data' => 'Tidak Ada',
        'created_at' => 'Dibuat',
        'updated_at' => 'Diubah',
        'updated_at' => 'Diubah',
    ],

    'mobile_app' => [
        'server' => [
            'title' => 'Server Aplikasi Seluler',
            'heading' => 'Server Aplikasi Seluler',
            'subheading' => 'Kelola Server Aplikasi Seluler.',
            'navigationLabel' => 'Server Aplikasi Seluler',
            'fields' => [
                'status' => [
                    'title' => 'Status',
                    'description' => 'Status'
                ],
                'action' => [
                    'title' => 'Aksi',
                    'description' => 'Aksi'
                ],
            ],
        ],
        'menu' => [
            'title' => 'Menu Aplikasi Seluler',
            'heading' => 'Menu Aplikasi Seluler',
            'subheading' => 'Kelola Menu Aplikasi Seluler.',
            'navigationLabel' => 'Menu Aplikasi Seluler',
            'fields' => [
                'status' => [
                    'title' => 'Status',
                    'description' => 'Status'
                ],
                'action' => [
                    'title' => 'Aksi',
                    'description' => 'Aksi'
                ],
            ],
        ],
        'news' => [
            'title' => 'Berita Aplikasi Seluler',
            'heading' => 'Berita Aplikasi Seluler',
            'subheading' => 'Kelola Berita Aplikasi Seluler.',
            'navigationLabel' => 'Berita Aplikasi Seluler',
            'fields' => [
                'status' => [
                    'title' => 'Status',
                    'description' => 'Status'
                ],
                'action' => [
                    'title' => 'Aksi',
                    'description' => 'Aksi'
                ],
            ],
        ],
        'version' => [
            'title' => 'Versi Aplikasi Seluler',
            'heading' => 'Versi Aplikasi Seluler',
            'subheading' => 'Kelola Versi Aplikasi Seluler.',
            'navigationLabel' => 'Versi Aplikasi Seluler',
            'fields' => [
                'status' => [
                    'title' => 'Status',
                    'description' => 'Status'
                ],
                'action' => [
                    'title' => 'Aksi',
                    'description' => 'Aksi'
                ],
            ],
        ],
    ],

    'master' => [
        'gender' => [
            'title' => 'Jenis kelamin',
            'heading' => 'Jenis kelamin',
            'subheading' => 'Kelola jenis kelamin.',
            'navigationLabel' => 'Jenis kelamin',
            'fields' => [
                'name' => [
                    'title' => 'Nama',
                    'description' => 'Nama'
                ],
            ],
        ],
        'religion' => [
            'title' => 'Agama',
            'heading' => 'Agama',
            'subheading' => 'Kelola Agama.',
            'navigationLabel' => 'Agama',
            'fields' => [
                'name' => [
                    'title' => 'Nama',
                    'description' => 'Nama'
                ],
            ],
        ],
        'team' => [
            'title' => 'Tenan',
            'heading' => 'Tenan',
            'subheading' => 'Kelola Tenan.',
            'navigationLabel' => 'Tenan',
            'fields' => [
                'name' => [
                    'title' => 'Nama',
                    'description' => 'Nama'
                ],
                'icon' => [
                    'title' => 'Ikon',
                    'description' => 'Ikon'
                ],
                'description' => [
                    'title' => 'Deskripsi',
                    'description' => 'Deskripsi'
                ],
            ]
        ],
    ],

    'indonesia' => [
        'province' => [
            'title' => 'Provinsi',
            'heading' => 'Provinsi',
            'subheading' => 'Kelola Provinsi.',
            'navigationLabel' => 'Provinsi',
            'fields' => [
                'code' => [
                    'title' => 'Kode Provinsi',
                    'description' => 'Kode Provinsi'
                ],
                'name' => [
                    'title' => 'Nama Provinsi',
                    'description' => 'Nama Provinsi'
                ],
                'meta' => [
                    'title' => 'Meta Provinsi',
                    'description' => 'Meta Provinsi'
                ],
            ],
        ],
        'city' => [
            'title' => 'Kota/Kabupaten',
            'heading' => 'Kota/Kabupaten',
            'subheading' => 'Kelola Kota/Kabupaten.',
            'navigationLabel' => 'Kota/Kabupaten',
            'fields' => [
                'code' => [
                    'title' => 'Kode Kota/Kabupaten',
                    'description' => 'Kode Kota/Kabupaten'
                ],
                'name' => [
                    'title' => 'Nama Kota/Kabupaten',
                    'description' => 'Nama Kota/Kabupaten'
                ],
                'meta' => [
                    'title' => 'Meta Kota/Kabupaten',
                    'description' => 'Meta Kota/Kabupaten'
                ],
            ],
        ],
        'district' => [
            'title' => 'Kecamatan',
            'heading' => 'Kecamatan',
            'subheading' => 'Kelola Kecamatan.',
            'navigationLabel' => 'Kecamatan',
            'fields' => [
                'code' => [
                    'title' => 'Kode Kecamatan',
                    'description' => 'Kode Kecamatan'
                ],
                'name' => [
                    'title' => 'Nama Kecamatan',
                    'description' => 'Nama Kecamatan'
                ],
                'meta' => [
                    'title' => 'Meta Kecamatan',
                    'description' => 'Meta Kecamatan'
                ],
            ],
        ],
        'village' => [
            'title' => 'Desa/Kelurahan',
            'heading' => 'Desa/Kelurahan',
            'subheading' => 'Kelola Desa/Kelurahan.',
            'navigationLabel' => 'Desa/Kelurahan',
            'fields' => [
                'code' => [
                    'title' => 'Kode Desa/Kelurahan',
                    'description' => 'Kode Desa/Kelurahan'
                ],
                'name' => [
                    'title' => 'Nama Desa/Kelurahan',
                    'description' => 'Nama Desa/Kelurahan'
                ],
                'meta' => [
                    'title' => 'Meta Desa/Kelurahan',
                    'description' => 'Meta Desa/Kelurahan'
                ],
            ],
        ],
    ],

];
