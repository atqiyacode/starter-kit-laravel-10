<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sample Page
    |--------------------------------------------------------------------------
    */
    // 'page' => [
    //     'title' => 'Page Title',
    //     'heading' => 'Page Heading',
    //     'subheading' => 'Page Subheading',
    //     'navigationLabel' => 'Page Navigation Label',
    //     'section' => [],
    //     'fields' => []
    // ],

    /*
    |--------------------------------------------------------------------------
    | General Settings
    |--------------------------------------------------------------------------
    */
    'general_settings' => [
        'title' => 'General Settings',
        'heading' => 'General Settings',
        'subheading' => 'Manage general site settings here.',
        'navigationLabel' => 'General',
        'sections' => [
            'site' => [
                'title' => 'Site',
                'description' => 'Manage basic settings.'
            ],
            'theme' => [
                'title' => 'Theme',
                'description' => 'Change default theme.'
            ],
        ],
        'fields' => [
            'brand_name' => 'Brand Name',
            'site_active' => 'Site Status',
            'brand_logoHeight' => 'Brand Logo Height',
            'brand_logo' => 'Brand Logo',
            'brand_logo_dark' => 'Brand Logo Dark',
            'site_favicon' => 'Site Favicon',
            'primary' => 'Primary',
            'secondary' => 'Secondary',
            'gray' => 'Gray',
            'success' => 'Success',
            'danger' => 'Danger',
            'info' => 'Info',
            'warning' => 'Warning',
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail Settings
    |--------------------------------------------------------------------------
    */
    'mail_settings' => [
        'title' => 'Mail Settings',
        'heading' => 'Mail Settings',
        'subheading' => 'Manage mail configuration.',
        'navigationLabel' => 'Mail',
        'sections' => [
            'config' => [
                'title' => 'Configuration',
                'description' => 'description'
            ],
            'sender' => [
                'title' => 'From (Sender)',
                'description' => 'description'
            ],
            'mail_to' => [
                'title' => 'Mail to',
                'description' => 'description'
            ],
        ],
        'fields' => [
            'placeholder' => [
                'receiver_email' => 'Receiver email..'
            ],
            'driver' => 'Driver',
            'host' => 'Host',
            'port' => 'Port',
            'encryption' => 'Encryption',
            'timeout' => 'Timeout',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'name' => 'Name',
            'mail_to' => 'Mail to',
        ],
        'actions' => [
            'send_test_mail' => 'Send Test Mail'
        ]
    ],

    /*
|--------------------------------------------------------------------------
| Table Page
|--------------------------------------------------------------------------
*/
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'table' => [
        'no_data' => 'No Data',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    /*
|--------------------------------------------------------------------------
| Master Panel
|--------------------------------------------------------------------------
*/
    'master' => [
        'gender' => [
            'title' => 'Gender',
            'heading' => 'Gender',
            'subheading' => 'Manage Genders.',
            'navigationLabel' => 'Gender',
            'fields' => [
                'name' => [
                    'title' => 'Name',
                    'description' => 'Name'
                ],
            ],
        ],
        'religion' => [
            'title' => 'Religion',
            'heading' => 'Religion',
            'subheading' => 'Manage Religions.',
            'navigationLabel' => 'Religion',
            'fields' => [
                'name' => [
                    'title' => 'Name',
                    'description' => 'Name'
                ],
            ],
        ],

        'team' => [
            'title' => 'Tenant',
            'heading' => 'Tenant',
            'subheading' => 'Manage Tenants.',
            'navigationLabel' => 'Tenant',
            'fields' => [
                'name' => [
                    'title' => 'Name',
                    'description' => 'Name'
                ],
                'icon' => [
                    'title' => 'icon',
                    'description' => 'icon'
                ],
                'description' => [
                    'title' => 'Description',
                    'description' => 'Description'
                ],
            ],
        ],
    ],

    /*
|--------------------------------------------------------------------------
| Indonesia Panel
|--------------------------------------------------------------------------
*/

    'indonesia' => [
        'province' => [
            'title' => 'Province',
            'heading' => 'Province',
            'subheading' => 'Manage provinces.',
            'navigationLabel' => 'Province',
            'fields' => [
                'code' => [
                    'title' => 'Province Code',
                    'description' => 'Province Code'
                ],
                'name' => [
                    'title' => 'Province Name',
                    'description' => 'Province Name'
                ],
                'meta' => [
                    'title' => 'Province Meta',
                    'description' => 'Province Meta'
                ],
            ],
        ],
        'city' => [
            'title' => 'City/Regency',
            'heading' => 'City/Regency',
            'subheading' => 'Manage cities/regencies.',
            'navigationLabel' => 'City/Regency',
            'fields' => [
                'code' => [
                    'title' => 'City Code',
                    'description' => 'City Code'
                ],
                'name' => [
                    'title' => 'City Name',
                    'description' => 'City Name'
                ],
                'meta' => [
                    'title' => 'City Meta',
                    'description' => 'City Meta'
                ],
            ],
        ],
        'district' => [
            'title' => 'District',
            'heading' => 'District',
            'subheading' => 'Manage districts.',
            'navigationLabel' => 'District',
            'fields' => [
                'code' => [
                    'title' => 'District Code',
                    'description' => 'District Code'
                ],
                'name' => [
                    'title' => 'District Name',
                    'description' => 'District Name'
                ],
                'meta' => [
                    'title' => 'District Meta',
                    'description' => 'District Meta'
                ],
            ],
        ],
        'village' => [
            'title' => 'Village',
            'heading' => 'Village',
            'subheading' => 'Manage villages/subdistricts.',
            'navigationLabel' => 'Village',
            'fields' => [
                'code' => [
                    'title' => 'Village Code',
                    'description' => 'Village Code'
                ],
                'name' => [
                    'title' => 'Village Name',
                    'description' => 'Village Name'
                ],
                'meta' => [
                    'title' => 'Village Meta',
                    'description' => 'Village Meta'
                ],
            ],
        ],
    ],



];
