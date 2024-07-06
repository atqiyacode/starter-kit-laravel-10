<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateExporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fila:exporter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Filament Exporter';

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
                foreach ($models as $key => $value) {
                    $this->generate($folderModule, $value, $panelSelected);
                }
                // $this->showModelList($models);
                // $modelIndex = $this->ask('Enter the number of the model to run the seeder for');

                // if (is_numeric($modelIndex) && $modelIndex > 0 && $modelIndex <= count($models)) {
                //     $modelName = $models[$modelIndex - 1];

                //     $this->info("Generate Filament Exporter '$modelName'...");
                //     $this->generate($folderModule, $modelName, $panelSelected);
                // } else {
                //     $this->error('Invalid input. Please enter a valid number.');
                // }
            }
        }
    }

    protected function generate($folderModule, $modelName, $panelSelected)
    {
        // Remove "PanelProvider" from the end
        $baseName = Str::before($panelSelected, 'PanelProvider');

        $exportPanelNamespace = "Filament\\$baseName\\Exports";

        $stubPath = base_path("stubs/atqiyacode/filament-exporter.stub");

        $modelNamespace = "Modules\\{$folderModule}\\App\\Models\\{$modelName}";

        $modelNameClass = "{$modelName}Exporter";

        $exportPath = app_path("Filament/{$baseName}/Exports/{$modelNameClass}.php");

        // Convert to snake case
        $snakeCaseString = Str::snake($modelName);

        // Replace underscores with hyphens
        $modelLabel = Str::ucfirst(Str::replace('_', ' ', $snakeCaseString));

        $this->createDirectory($exportPath);

        // Get table name from model
        $modelClass = new $modelNamespace;
        $table = $modelClass->getTable();

        // Get columns from the table
        $columns = Schema::getColumnListing($table);

        // Exclude specific columns
        $excludedColumns = ['id', 'team_id', 'deleted_at', 'created_at', 'updated_at'];
        $columns = array_filter($columns, fn ($column) => !in_array($column, $excludedColumns));

        // Format columns for the stub
        $formattedColumns = array_map(fn ($column) => "ExportColumn::make('$column')", $columns);
        $columnsString = implode(",\n            ", $formattedColumns);

        if (!File::exists($exportPath)) {
            $stubContent = str_replace(
                [
                    '$NAMESPACE$',
                    '$MODEL_NAMESPACE$',
                    '$CLASS$',
                    '$MODEL$',
                    '$MODEL_LABEL$',
                    '$COLUMNS$',
                ],
                [
                    "{$exportPanelNamespace}",
                    "{$modelNamespace}",
                    "{$modelNameClass}",
                    "{$modelName}",
                    "{$modelLabel}",
                    "{$columnsString}",
                ],
                File::get($stubPath)
            );
            File::put($exportPath, $stubContent);

            $this->info("INFO : {$modelLabel} Exporter created successfully.");
        } else {
            $this->error("ERROR : {$modelLabel} Exporter already exists.");
        }

        $this->info("------- DONE -------");
    }

    protected function createDirectory($path)
    {
        $directory = dirname($path);

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
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
