<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->autoBindRepositories();
        $this->autoBindServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Schema::defaultStringLength(191);
        JsonResource::withoutWrapping();
    }

    private function autoBindItems(string $type, string $namespace): void
    {
        $modulesFolderPath = base_path('Modules');
        $modules = [];

        // Get all subfolders in the Modules directory
        $subfolders = glob($modulesFolderPath . '/*', GLOB_ONLYDIR);

        // Extract subfolder names
        foreach ($subfolders as $subfolder) {
            $modules[] = basename($subfolder);
        }

        $listModules = array_filter($modules);

        foreach ($listModules as $moduleName) {
            // Define the directory where your items are located
            $itemsDirectory = base_path("Modules/{$moduleName}/App/{$namespace}");

            // Scan the directory for PHP files
            $itemFiles = glob("{$itemsDirectory}/*", GLOB_ONLYDIR);

            foreach ($itemFiles as $itemFile) {
                // Extract the class name from the file path
                $className = basename($itemFile);

                // Define the namespace for interfaces
                $interfaceNamespace = "Modules\\{$moduleName}\\App\\{$namespace}\\{$className}\\";

                // Assuming your convention is ClassNameType for interfaces
                $interface = "{$interfaceNamespace}{$className}{$type}";

                // Assuming your convention is ClassNameTypeImplement for implementations
                $implementationClass = "{$interfaceNamespace}{$className}{$type}Implement";

                // Bind the interface to its implementation
                $this->app->bind($interface, $implementationClass);
            }
        }
    }

    private function autoBindRepositories(): void
    {
        $this->autoBindItems('Repository', 'Repositories');
    }

    private function autoBindServices(): void
    {
        $this->autoBindItems('Service', 'Services');
    }
}
