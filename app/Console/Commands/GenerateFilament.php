<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class GenerateFilament extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:filament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $panels = $this->getPanelList();
        $this->showPanelList($panels);

        $panelIndex = $this->ask('Select the Panel ?');
        $panelSelected = $panels[$panelIndex - 1];


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

                    $simple = $this->confirm('is Simple?', false);

                    $this->info("Generate Filament Resource '$modelName'...");
                    $result = $this->generate($folderModule, $modelName, $simple, $panelSelected);
                    if ($result === 0) {
                        $this->info("Generate Filament Resource completed for '$modelName'.");
                    } else {
                        $this->error("Failed to generate Filament Resource for '$modelName'.");
                    }
                } else {
                    $this->error('Invalid input. Please enter a valid number.');
                }
            }
        }
    }

    protected function generate($folderModule, $modelName, $simple, $panelSelected)
    {
        // Remove "PanelProvider" from the end
        $baseName = Str::before($panelSelected, 'PanelProvider');

        // Convert to snake case
        $snakeCaseString = Str::snake($baseName);

        // Replace underscores with hyphens
        $panelName = Str::replace('_', '-', $snakeCaseString);


        $modelNamespace = "Modules\\$folderModule\\App\\Models";
        $fullModelName = $modelNamespace . '\\' . $modelName;

        // Check if the model uses SoftDeletes
        $usesSoftDeletes = in_array(
            'Illuminate\Database\Eloquent\SoftDeletes',
            class_uses_recursive($fullModelName)
        );

        // Base command and options
        $command = 'make:filament-resource';
        $options = [
            'name' => $modelName,
            '--model-namespace' => $modelNamespace,
            '--panel' => Str::slug($panelName),
        ];

        // Add simple option
        $options['--generate'] = true;
        if ($simple) {
            $options['--simple'] = true;
        } else {
            $options['--view'] = true;
        }

        // Add soft deletes option
        if ($usesSoftDeletes) {
            $options['--soft-deletes'] = true;
        }

        // Call the Artisan command
        $result = Artisan::call($command, $options);
        return $result;
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

    protected function getPanelList()
    {
        $modelNamespace = "App\\Providers\\Filament\\"; // Adjust the namespace based on your project structure
        $modelPath = base_path("app/Providers/Filament");

        $models = [];

        $files = File::allFiles($modelPath);

        foreach ($files as $file) {
            $className = $modelNamespace . $file->getBasename('.php');
            $modelName = class_exists($className) ? class_basename($className) : null;
            $models[] = $modelName;
        }

        return array_filter($models);
    }

    protected function showPanelList($panels)
    {
        $tableData = [];

        foreach ($panels as $key => $panel) {
            $tableData[] = [$key + 1, $panel];
        }

        $this->table(['Number', 'Panel'], $tableData);
    }
}
