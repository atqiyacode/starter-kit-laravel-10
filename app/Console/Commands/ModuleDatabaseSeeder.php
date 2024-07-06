<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class ModuleDatabaseSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Module Database Seeder';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $modules = $this->getModuleList();
        $this->showModulelList($modules);
        $modelIndex = $this->ask('Select the Module ?');
        $folderModule = $modules[$modelIndex - 1];

        if (!empty($folderModule)) {

            $models = $this->getModelList($folderModule);
            if (empty($models)) {
                $this->info('No models found.');
            } else {
                $this->showModelList($models);
                $modelIndex = $this->ask('Enter the number of the model to run the seeder for');

                if (is_numeric($modelIndex) && $modelIndex > 0 && $modelIndex <= count($models)) {
                    $modelName = $models[$modelIndex - 1];

                    // Run the seeder
                    $seederClass = "Modules\\$folderModule\\Database\\Seeders\\{$modelName}Seeder";

                    $this->info("Seeding '$modelName'...");
                    Artisan::call('db:seed', ['--class' => $seederClass]);
                    $this->info("Seeding completed for '$modelName'.");
                } else {
                    $this->error('Invalid input. Please enter a valid number.');
                }
            }
        }
    }

    /**
     * Get a list of all models in the application.
     *
     * @return array
     */
    protected function getModelList($folderModule)
    {
        $modelNamespace = "Modules\\$folderModule\\App\\Models\\"; // Adjust the namespace based on your project structure
        $modelPath = base_path("Modules/$folderModule/App/Models");

        $models = [];

        $files = File::allFiles($modelPath);

        foreach ($files as $file) {
            $className = $modelNamespace . $file->getBasename('.php');
            $modelName = class_exists($className) ? class_basename($className) : null;
            $models[] = $modelName;
        }

        return array_filter($models);
    }

    /**
     * Display a table of models.
     *
     * @param array $models
     * @return void
     */
    protected function showModelList(array $models)
    {
        $tableData = [];

        foreach ($models as $key => $model) {
            $tableData[] = [$key + 1, $model];
        }

        $this->table(['Number', 'Model'], $tableData);
    }

    protected function getModuleList()
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

    protected function showModulelList($modules)
    {
        $tableData = [];

        foreach ($modules as $key => $model) {
            $tableData[] = [$key + 1, $model];
        }

        $this->table(['Number', 'Module'], $tableData);
    }
}
