<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;

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
    protected $description = 'Generate a Filament resource based on the selected module and model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get and display the list of panels with search functionality
        $panels = $this->getPanelList();
        $panelSelected = select(
            'Select the Panel',
            $panels,
            scroll: 15,
            hint: 'Select One'
        );

        // Get and display the list of modules with search functionality
        $modules = $this->getModuleList();
        $folderModule = select(
            'Select the Module',
            $modules,
            scroll: 15,
            hint: 'Select One'
        );

        if (!empty($folderModule)) {
            // Get and display the list of models with search functionality
            $models = $this->getModelList($folderModule);
            if (empty($models)) {
                $this->info('No models found.');
            } else {
                $modelName = select(
                    'Select the Model',
                    $models,
                    scroll: 15,
                    hint: 'Select One'
                );

                // Confirm if the user wants a simple resource
                $simple = confirm('Is this a simple resource?', false);

                $this->info("🕐 Generating Filament Resource '$modelName'...");
                $result = $this->generate($folderModule, $modelName, $simple, $panelSelected);
                if ($result === 0) {
                    $this->info("✅ Generation of Filament Resource completed for '$modelName'.");
                } else {
                    $this->error("🚨 Failed to generate Filament Resource for '$modelName'.");
                }
            }
        }
    }

    protected function generate($folderModule, $modelName, $simple, $panelSelected)
    {
        // Remove "PanelProvider" from the end of the panel name
        $baseName = Str::before($panelSelected, 'PanelProvider');

        // Convert the panel name to snake case and replace underscores with hyphens
        $snakeCaseString = Str::snake($baseName);
        $panelName = Str::replace('_', '-', $snakeCaseString);

        // Define the model namespace
        $modelNamespace = "Modules\\$folderModule\\App\\Models";
        $fullModelName = $modelNamespace . '\\' . $modelName;

        // Check if the model uses SoftDeletes
        $usesSoftDeletes = in_array(
            'Illuminate\Database\Eloquent\SoftDeletes',
            class_uses_recursive($fullModelName)
        );

        // Base command and options for generating the resource
        $command = 'make:filament-resource';
        $options = [
            'name' => $modelName,
            '--model-namespace' => $modelNamespace,
            '--panel' => Str::slug($panelName),
        ];

        // Add options for generating the resource
        $options['--generate'] = true;
        if ($simple) {
            $options['--simple'] = true;
        } else {
            $options['--view'] = true;
        }

        // Add the soft deletes option if applicable
        if ($usesSoftDeletes) {
            $options['--soft-deletes'] = true;
        }

        // Call the Artisan command to generate the resource
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
        $modelNamespace = "Modules\\$folderModule\\App\\Models\\";
        $modelPath = base_path("Modules/$folderModule/App/Models");

        $models = [];

        // Get all files in the model path and add them to the list
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

        // Prepare the data for the table
        foreach ($models as $key => $model) {
            $tableData[] = [$key + 1, $model];
        }

        // Display the table
        $this->table(['Number', 'Model'], $tableData);
    }

    /**
     * Get a list of modules.
     *
     * @return array
     */
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

    /**
     * Display a table of modules.
     *
     * @param array $modules
     * @return void
     */
    protected function showModuleList($modules)
    {
        $tableData = [];

        // Prepare the data for the table
        foreach ($modules as $key => $model) {
            $tableData[] = [$key + 1, $model];
        }

        // Display the table
        $this->table(['Number', 'Module'], $tableData);
    }

    /**
     * Get a list of panels.
     *
     * @return array
     */
    protected function getPanelList()
    {
        $modelNamespace = "App\\Providers\\Filament\\";
        $modelPath = base_path("app/Providers/Filament");

        $models = [];

        // Get all files in the model path and add them to the list
        $files = File::allFiles($modelPath);

        foreach ($files as $file) {
            $className = $modelNamespace . $file->getBasename('.php');
            $modelName = class_exists($className) ? class_basename($className) : null;
            $models[] = $modelName;
        }

        return array_filter($models);
    }

    /**
     * Display a table of panels.
     *
     * @param array $panels
     * @return void
     */
    protected function showPanelList($panels)
    {
        $tableData = [];

        // Prepare the data for the table
        foreach ($panels as $key => $panel) {
            $tableData[] = [$key + 1, $panel];
        }

        // Display the table
        $this->table(['Number', 'Panel'], $tableData);
    }
}
