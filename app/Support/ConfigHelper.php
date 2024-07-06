<?php

namespace App\Support;

use Essa\APIToolKit\Enum\GeneratorFilesType;

class ConfigHelper
{
    public static function syncModules()
    {
        $modules = self::getModuleList();
        $data = [];
        $data['default'] = [
            GeneratorFilesType::MODEL => [
                'folder_path' => app_path('Models'),
                'file_name' => '{ModelName}.php',
                'namespace' => 'App\Models',
            ],
            GeneratorFilesType::FACTORY => [
                'folder_path' => database_path('factories'),
                'file_name' => '{ModelName}Factory.php',
                'namespace' => 'Database\Factories',
            ],
            GeneratorFilesType::SEEDER => [
                'folder_path' => database_path('seeders'),
                'file_name' => '{ModelName}Seeder.php',
                'namespace' => 'Database\Seeders',
            ],
            GeneratorFilesType::CONTROLLER => [
                'folder_path' => app_path('Http/Controllers/API'),
                'file_name' => '{ModelName}Controller.php',
                'namespace' => 'App\Http\Controllers\API',
            ],
            GeneratorFilesType::RESOURCE => [
                'folder_path' => app_path('Http/Resources/{ModelName}'),
                'file_name' => '{ModelName}Resource.php',
                'namespace' => "App\Http\Resources\{ModelName}",
            ],
            GeneratorFilesType::TEST => [
                'folder_path' => base_path('tests/Feature'),
                'file_name' => '{ModelName}Test.php',
                'namespace' => 'Tests\Feature',
            ],
            GeneratorFilesType::CREATE_REQUEST => [
                'folder_path' => app_path('Http/Requests/{ModelName}'),
                'file_name' => 'Create{ModelName}Request.php',
                'namespace' => "App\Http\Requests\{ModelName}",
            ],
            GeneratorFilesType::UPDATE_REQUEST => [
                'folder_path' => app_path('Http/Requests/{ModelName}'),
                'file_name' => 'Update{ModelName}Request.php',
                'namespace' => "App\Http\Requests\{ModelName}",
            ],
            GeneratorFilesType::FILTER => [
                'folder_path' => app_path('Filters'),
                'file_name' => '{ModelName}Filters.php',
                'namespace' => 'App\Filters',
            ],
            GeneratorFilesType::MIGRATION => [
                'folder_path' => database_path('migrations'),
                'file_name' => date('Y_m_d_His') . '_create_{TableName}_table.php',
                'namespace' => null,
            ],
            GeneratorFilesType::ROUTES => [
                'folder_path' => base_path('routes'),
                'file_name' => 'api.php',
                'namespace' => null,
            ],
        ];
        foreach ($modules as $key) {
            $data[$key] = self::loadFilePath($key);
        }
        return $data;
    }

    public static function syncModuleUrl()
    {
        $modules = self::getModuleList();
        $data = [];

        $data['default'] = '/api';
        foreach ($modules as $key) {
            $data[$key] = '/api';
        }
        return $data;
    }

    private static function getModuleList()
    {
        $modulesFolderPath = base_path('Modules');
        $subfolderNames = [];

        // Get all subfolders in the Modules directory
        $subfolders = glob($modulesFolderPath . '/*', GLOB_ONLYDIR);

        // Extract subfolder names
        foreach ($subfolders as $subfolder) {
            $subfolderNames[] = basename($subfolder);
        }

        return array_filter($subfolderNames);
    }

    private static function loadFilePath($module)
    {
        return [
            GeneratorFilesType::MODEL => [
                'folder_path' => base_path("Modules/$module/App/Models"),
                'file_name' => '{ModelName}.php',
                'namespace' => "Modules\\$module\\App\\Models",
            ],
            GeneratorFilesType::FACTORY => [
                'folder_path' => base_path("Modules/$module/Database/Factories"),
                'file_name' => '{ModelName}Factory.php',
                'namespace' => "Modules\\$module\\Database\\Factories",
            ],
            GeneratorFilesType::SEEDER => [
                'folder_path' => base_path("Modules/$module/Database/Seeders"),
                'file_name' => '{ModelName}Seeder.php',
                'namespace' => "Modules\\$module\\Database\\Seeders",
            ],
            GeneratorFilesType::CONTROLLER => [
                'folder_path' => base_path("Modules/$module/App/Http/Controllers/API"),
                'file_name' => '{ModelName}Controller.php',
                'namespace' => "Modules\\$module\\App\\Http\\Controllers\\API",
            ],
            GeneratorFilesType::RESOURCE => [
                'folder_path' => base_path("Modules/$module/App/Http/Resources/{ModelName}"),
                'file_name' => '{ModelName}Resource.php',
                'namespace' => "Modules\\$module\\App\\Http\\Resources\\{ModelName}",
            ],
            GeneratorFilesType::TEST => [
                'folder_path' => base_path("Modules/$module/tests/Feature"),
                'file_name' => '{ModelName}Test.php',
                'namespace' => "Modules\\$module\\App\\Tests\\Feature",
            ],
            GeneratorFilesType::CREATE_REQUEST => [
                'folder_path' => base_path("Modules/$module/App/Http/Requests/{ModelName}"),
                'file_name' => 'Create{ModelName}Request.php',
                'namespace' => "Modules\\$module\\App\\Http\\Requests\\{ModelName}",
            ],
            GeneratorFilesType::UPDATE_REQUEST => [
                'folder_path' => base_path("Modules/$module/App/Http/Requests/{ModelName}"),
                'file_name' => 'Update{ModelName}Request.php',
                'namespace' => "Modules\\$module\\App\\Http\\Requests\\{ModelName}",
            ],
            GeneratorFilesType::FILTER => [
                'folder_path' => base_path("Modules/$module/App/Filters"),
                'file_name' => '{ModelName}Filters.php',
                'namespace' => "Modules\\$module\\App\\Filters",
            ],
            GeneratorFilesType::MIGRATION => [
                'folder_path' => base_path("Modules/$module/Database/migrations"),
                'file_name' => date('Y_m_d_His') . '_create_{TableName}_table.php',
                'namespace' => "Modules\\$module\\Database\\migrations",
            ],
            GeneratorFilesType::ROUTES => [
                'folder_path' => base_path("Modules/$module/routes"),
                'file_name' => 'api.php',
                'namespace' => "Modules\\$module\\App\\routes",
            ],
        ];
    }
}
