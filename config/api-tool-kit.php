<?php

use App\Support\ConfigHelper;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Generators
    |--------------------------------------------------------------------------
    |
    | The default options that will be created if no option is specified.
    |
    | Supported options: 'seeder', 'controller', 'request', 'resource', 'factory',
    |                    'migration', 'filter', 'test', 'routes'
    |
    */
    'default_generates' => [
        'seeder',
        'controller',
        'request',
        'resource',
        'factory',
        'migration',
        'filter',
        'test',
        'routes',
    ],
    /*
    |--------------------------------------------------------------------------
    | Default Generators
    |--------------------------------------------------------------------------
    | Number of items per page when using dynamic pagination.
    */
    'default_pagination_number' => 10,

    /*
    |--------------------------------------------------------------------------
    | Default Datetime Format for API Resources
    |--------------------------------------------------------------------------
    | The default format for displaying date and time values in API resources.
    | Used by the dateTimeFormat function when generating API resource responses,
    | ensuring consistent formatting for datetime values.
    */
    'datetime_format' => 'Y-m-d H:i:s',

    /*
    |--------------------------------------------------------------------------
    | Default Group
    |--------------------------------------------------------------------------
    |
    | Define the default generator group that will be used by default when
    | no specific group is specified. Users can still create and use custom
    | groups in addition to this default group.
    |
    */
    'default_group' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Custom Groups Files Paths
    |--------------------------------------------------------------------------
    |
    | Define file paths for different file types within custom groups.
    | Users can assign classes to each generator type for both the 'default' and
    | custom groups, specifying where the generated files will be stored.
    |
    */
    'groups_files_paths' => ConfigHelper::syncModules(),

    /*
    |--------------------------------------------------------------------------
    | Groups Base URL Prefixes
    |--------------------------------------------------------------------------
    |
    | Define the base URLs for different groups in your application.
    | These base URLs are used as prefixes for routes defined within each
    | group.
    |
    */
    'groups_url_prefixes' => ConfigHelper::syncModuleUrl(),
];
