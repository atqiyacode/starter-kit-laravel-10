<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class ModuleGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:module-generator {ModelName?} {ModuleName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Module Easily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the list of modules
        $modules = $this->getModuleList();

        // Use a select prompt with search functionality to choose a module
        $module = select(
            label: 'Select the Module',
            options: $modules,
            scroll: 15
        );

        // Use the text prompt to ask for the model name if not provided
        $model = $this->argument('ModelName') ?: text(
            label: 'What is the Model name?'
        );

        // Use confirm prompts to ask for routes and soft delete options
        $routes = confirm('Need Routes?', true);
        $softDelete = confirm('Need Soft Delete?', true);

        // Use the text prompt to ask for the table schema
        $table = text('Write your table schema');

        // Construct the Artisan command
        $command = 'api:generate ' . $model . ' "' . $table . '" -RrmF' .
            ($softDelete ? ' --soft-delete' : '') .
            ($module ? " --group=$module" : '');

        // Call the Artisan command
        Artisan::call($command);

        // Wait for a few seconds
        $this->info('Processing...');
        sleep(3);
        $this->info('✅ Finish ...');

        // Advance the process (not provided in your code, assuming a custom method)
        $this->advance($model, $module, $softDelete);
    }

    public function advance($modelName, $folderModule, $softDelete)
    {
        $modulesDirectory = base_path("Modules" . DIRECTORY_SEPARATOR . "{$folderModule}");
        $modelDirectory = base_path("Modules" . DIRECTORY_SEPARATOR . "{$folderModule}" . DIRECTORY_SEPARATOR . "App" . DIRECTORY_SEPARATOR . "Models" . DIRECTORY_SEPARATOR . "{$modelName}.php");

        if (!File::exists($modulesDirectory)) {
            $this->error('Modules directory not found. Please create the Modules directory.');
            return;
        }

        if (!File::exists($modelDirectory)) {
            $this->error('Model not found. Please create the Model.');
            return;
        }

        if ($this->confirm('Do you want to generate All (Controller, Seeder, Factory, Observer, Event, Policy, Import, Export, and Service Repository )?', true)) {

            $this->createRepositoryImplement($folderModule, $modelName, $softDelete);
            $this->createInterface('Repository', $folderModule, $modelName, $softDelete);

            $this->createServiceImplement($folderModule, $modelName, $softDelete);
            $this->createInterface('Service', $folderModule, $modelName, $softDelete);

            $this->createController($folderModule, $modelName, $softDelete);

            $this->createSeeder($folderModule, $modelName);

            $this->createFactory($folderModule, $modelName);

            $this->createEvent($folderModule, $modelName);

            $this->createPolicy($folderModule, $modelName);

            $this->createImport($folderModule, $modelName);

            // $this->createExport($folderModule, $modelName);

            $this->createObserver($folderModule, $modelName, $softDelete);

            $this->createRoute($folderModule, $modelName, $softDelete);
        } else {
            if ($this->confirm('Do you want to generate Controller?', true)) {
                $this->createRepositoryImplement($folderModule, $modelName, $softDelete);
                $this->createInterface('Repository', $folderModule, $modelName, $softDelete);

                $this->createServiceImplement($folderModule, $modelName, $softDelete);
                $this->createInterface('Service', $folderModule, $modelName, $softDelete);

                $this->createController($folderModule, $modelName, $softDelete);
                $this->createRoute($folderModule, $modelName, $softDelete);
            }

            if ($this->confirm('Do you want to generate Seeder?', true)) {
                $this->createSeeder($folderModule, $modelName);
            }

            if ($this->confirm('Do you want to generate Factory?', true)) {
                $this->createFactory($folderModule, $modelName);
            }

            if ($this->confirm('Do you want to generate Observer?', true)) {
                $this->createObserver($folderModule, $modelName, $softDelete);
            }

            if ($this->confirm('Do you want to generate Event?', true)) {
                $this->createEvent($folderModule, $modelName);
            }

            if ($this->confirm('Do you want to generate Policy?', true)) {
                $this->createPolicy($folderModule, $modelName);
            }

            if ($this->confirm('Do you want to generate Import?', true)) {
                $this->createImport($folderModule, $modelName);
            }
            if ($this->confirm('Do you want to generate Export?', true)) {
                $this->createExport($folderModule, $modelName);
            }
        }
        // info success generated files

        $this->info('🌟 Module Content generated successfully 🌟');
    }
    protected function createController($folderModule, $modelName, $SoftDelete)
    {
        $stubPath = $SoftDelete ? base_path("stubs/controller.stub") : base_path("stubs/controller-plain.stub");
        $stubPathApi = $SoftDelete ? base_path("stubs/controller-api.stub") : base_path("stubs/controller-api-plain.stub");

        $controllerPath = base_path("Modules/{$folderModule}/App/Http/Controllers/{$modelName}Controller.php");
        $controllerPathApi = base_path("Modules/{$folderModule}/App/Http/Controllers/API/Api{$modelName}Controller.php");

        $this->createDirectory($controllerPath);

        if (!File::exists($controllerPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModule', 'DummyModel'],
                [
                    "Modules\\{$folderModule}\\App\\Http\\Controllers",
                    "{$modelName}Controller",
                    "$folderModule",
                    "$modelName",
                ],
                File::get($stubPath)
            );
            File::put($controllerPath, $stubContent);

            $stubContentApi = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModule', 'DummyModel'],
                [
                    "Modules\\{$folderModule}\\App\\Http\\Controllers\\API",
                    "Api{$modelName}Controller",
                    "$folderModule",
                    "$modelName",
                ],
                File::get($stubPathApi)
            );
            File::put($controllerPathApi, $stubContentApi);

            $this->info("✅ Controller - {$modelName}Controller created successfully.");
        } else {
            $this->warn("🚨 Controller - {$modelName}Controller already exists.");
        }
    }

    protected function createRoute($folderModule, $modelName, $SoftDelete)
    {
        $routeFilePath = base_path("Modules/{$folderModule}/routes/api.php");

        // Check if the routes file exists
        if (!File::exists($routeFilePath)) {
            $this->error('Routes file not found!');
            return;
        }

        // Pluralize and use lower camel case for the prefix
        $group = Str::slug(Str::kebab($folderModule));
        $slug = Str::plural(Str::kebab($modelName));

        // Define the custom routes
        $customRoutes = <<<EOD

        /*===========================
        =           $folderModule - $modelName           =
        =============================*/
        Route::middleware(['auth:sanctum'])->prefix('{$group}')->group(function () {
            Route::apiResource('/{$slug}', \\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class);
            Route::group([
                'prefix' => '{$slug}',
            ], function () {
                Route::get('{id}/restore', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'restore']);
                Route::delete('{id}/force-delete', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'forceDelete']);
                Route::post('destroy-multiple', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'destroyMultiple']);
                Route::post('restore-multiple', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'restoreMultiple']);
                Route::post('force-delete-multiple', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'forceDeleteMultiple']);
                Route::get('export/{format}', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\API\\Api{$modelName}Controller::class, 'export']);
            });
        });
        /*===========================
        =           $folderModule - $modelName           =
        =============================*/

        EOD;

        $customRoutesPlain = <<<EOD

        /*===========================
        =           $folderModule - $modelName           =
        =============================*/
        Route::middleware(['auth:sanctum'])->prefix('{$folderModule}')->group(function () {
            Route::apiResource('/{$slug}', \\Modules\\{$folderModule}\\App\\Http\\Controllers\\{$modelName}Controller::class);
            Route::group([
                'prefix' => '{$slug}',
            ], function () {
                Route::post('destroy-multiple', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\{$modelName}Controller::class, 'destroyMultiple']);
                Route::get('export/{format}', [\\Modules\\{$folderModule}\\App\\Http\\Controllers\\{$modelName}Controller::class, 'export']);
            });
        });
        /*===========================
        =           $folderModule - $modelName           =
        =============================*/

        EOD;

        File::append($routeFilePath, $SoftDelete ? $customRoutes : $customRoutesPlain);


        $this->info("✅ $folderModule - $modelName routes added successfully!");
    }

    protected function createSeeder($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/seeder.stub");

        $seederPath = base_path("Modules/{$folderModule}/Database/Seeders/{$modelName}Seeder.php");

        $this->createDirectory($seederPath);

        if (!File::exists($seederPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyFactoryPath', 'DummyFactoryName', 'DummyModelPath'],
                [
                    "Modules\\$folderModule\\Database\\Seeders",
                    "{$modelName}Seeder",
                    "Modules\\$folderModule\\Database\\Factories\\{$modelName}Factory",
                    "{$modelName}Factory",
                    "Modules\\$folderModule\\App\\Models\\{$modelName}",
                ],
                File::get($stubPath)
            );
            File::put($seederPath, $stubContent);

            $this->info("✅ Seeder - {$modelName}Seeder created successfully.");
        } else {
            $this->warn("🚨 Seeder - {$modelName}Seeder already exists.");
        }
    }
    protected function createFactory($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/factory.stub");

        $factoryPath = base_path("Modules/{$folderModule}/Database/Factories/{$modelName}Factory.php");

        $this->createDirectory($factoryPath);

        if (!File::exists($factoryPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModelPath'],
                [
                    "Modules\\$folderModule\\Database\\Factories",
                    "{$modelName}Factory",
                    "\\Modules\\$folderModule\\App\\Models\\$modelName",
                ],
                File::get($stubPath)
            );
            File::put($factoryPath, $stubContent);

            $this->info("✅ Factory - {$modelName}Factory created successfully.");
        } else {
            $this->warn("🚨 Factory - {$modelName}Factory already exists.");
        }
    }
    protected function createObserver($folderModule, $modelName, $SoftDelete)
    {
        $stubPath = $SoftDelete ? base_path("stubs/observer.stub") : base_path("stubs/observer-plain.stub");

        $observerPath = base_path("Modules/{$folderModule}/App/Observers/{$modelName}Observer.php");

        $this->createDirectory($observerPath);

        if (!File::exists($observerPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModelClass', 'DummyEventClass', 'DummyModel', 'DummyResourceClass'],
                [
                    "Modules\\{$folderModule}\\App\\Observers",
                    "{$modelName}Observer",
                    "Modules\\{$folderModule}\\App\\Models\\$modelName",
                    "Modules\\{$folderModule}\\App\\Events\\{$modelName}Event",
                    "$modelName",
                    "\\Modules\\{$folderModule}\\App\\Http\\Resources\\{$modelName}\\{$modelName}Resource",
                ],
                File::get($stubPath)
            );
            File::put($observerPath, $stubContent);

            $this->info("✅ Observer - {$modelName}Observer created successfully.");
        } else {
            $this->warn("🚨 Observer - {$modelName}Observer already exists.");
        }
    }
    protected function createEvent($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/event.stub");

        $eventPath = base_path("Modules/{$folderModule}/App/Events/{$modelName}Event.php");

        $this->createDirectory($eventPath);

        if (!File::exists($eventPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyChannel', 'DummyBroadcast'],
                [
                    "Modules\\{$folderModule}\\App\\Events",
                    "{$modelName}Event",
                    str_replace('_', '-', Str::snake($modelName . 'Channel')),
                    str_replace('_', '-', Str::snake($modelName . 'Event')),
                ],
                File::get($stubPath)
            );
            File::put($eventPath, $stubContent);

            $this->info("✅ Event - {$modelName}Event created successfully.");
        } else {
            $this->warn("🚨 Event - {$modelName}Event already exists.");
        }
    }
    protected function createPolicy($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/policy.stub");

        $policyPath = base_path("Modules/{$folderModule}/App/Policies/{$modelName}Policy.php");

        $this->createDirectory($policyPath);

        if (!File::exists($policyPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModelClass', 'DummyModel', 'ModelData'],
                [
                    "Modules\\{$folderModule}\\App\\Policies",
                    "{$modelName}Policy",
                    "Modules\\{$folderModule}\\App\\Models\\$modelName",
                    "$modelName",
                    lcfirst($modelName),
                ],
                File::get($stubPath)
            );
            File::put($policyPath, $stubContent);

            $this->info("✅ Policy - {$modelName}Policy created successfully.");
        } else {
            $this->warn("🚨 Policy - {$modelName}Policy already exists.");
        }
    }
    protected function createExport($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/export.view.stub");

        $exportPath = base_path("Modules/{$folderModule}/App/Exports/{$modelName}Export.php");

        $this->createDirectory($exportPath);

        if (!File::exists($exportPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModule', 'DummyModel'],
                [
                    "Modules\\{$folderModule}\\App\\Exports",
                    "{$modelName}Export",
                    "$folderModule",
                    "$modelName",
                ],
                File::get($stubPath)
            );
            File::put($exportPath, $stubContent);

            $this->createExportView($folderModule, $modelName);

            $this->info("✅ Export - {$modelName}Export created successfully.");
        } else {
            $this->warn("🚨 Export - {$modelName}Export already exists.");
        }
    }
    protected function createExportView($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/export.table.stub");

        $exportPath = base_path("resources/views/exports/$folderModule/$modelName.blade.php");

        $this->createDirectory($exportPath);

        if (!File::exists($exportPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyClass', 'DummyModel'],
                [
                    "Modules\\{$folderModule}\\App\\Exports",
                    "{$modelName}Export",
                    "$modelName",
                ],
                File::get($stubPath)
            );
            File::put($exportPath, $stubContent);
            $this->info("✅ View - {$modelName}.blade.php created successfully.");
        } else {
            $this->warn("🚨 View - {$modelName}.blade.php already exists.");
        }
    }

    protected function createImport($folderModule, $modelName)
    {
        $stubPath = base_path("stubs/import.collection.stub");

        $importPath = base_path("Modules/{$folderModule}/App/Imports/{$modelName}Import.php");

        $this->createDirectory($importPath);

        if (!File::exists($importPath)) {
            $stubContent = str_replace(
                ['DummyNamespace', 'DummyFullModelClass', 'DummyClass', 'DummyModelClass'],
                [
                    "Modules\\{$folderModule}\\App\\Imports",
                    "Modules\\{$folderModule}\\App\\Models\\{$modelName}",
                    "{$modelName}Import",
                    "$modelName",
                ],
                File::get($stubPath)
            );
            File::put($importPath, $stubContent);
            $this->info("✅ Import - {$modelName}Import created successfully.");
        } else {
            $this->warn("🚨 Import - {$modelName}Import already exists.");
        }
    }

    protected function createInterface($type, $folderModule, $modelName, $SoftDelete)
    {
        $stubPath = $SoftDelete ? base_path("stubs/{$type}Interface.stub") : base_path("stubs/{$type}Interface-plain.stub");
        $folderType = $type === 'Repository' ? 'Repositories' : 'Services';
        $interfacePath = base_path("Modules/{$folderModule}/App/{$folderType}/{$modelName}/{$modelName}{$type}.php");

        $this->createDirectory($interfacePath);

        if (!File::exists($interfacePath)) {
            $stubContent = str_replace(
                ['$NAMESPACE$', '$CLASS$'],
                ["Modules\\{$folderModule}\\App\\{$folderType}\\{$modelName}", "{$modelName}{$type}"],
                File::get($stubPath)
            );
            File::put($interfacePath, $stubContent);

            $this->info("✅ Interface - {$modelName}{$type}Interface created successfully.");
        } else {
            $this->warn("🚨 Interface - {$modelName}{$type}Interface already exists.");
        }
    }

    protected function createRepositoryImplement($folderModule, $modelName, $SoftDelete)
    {
        $stubPath = $SoftDelete ? base_path("stubs/RepositoryImplement.stub") : base_path("stubs/RepositoryImplement-plain.stub");
        $implementPath = base_path("Modules/{$folderModule}/App/Repositories/{$modelName}/{$modelName}RepositoryImplement.php");

        $this->createDirectory($implementPath);

        if (!File::exists($implementPath)) {
            $stubContent = str_replace(
                [
                    '$MODULE_NAME$',

                    '$NAMESPACE$',
                    '$CLASS$',

                    '$REPOSITORY_INTERFACE$',

                    '$MODEL$',
                    '$MODEL_NAME$',

                    '$EXPORT_NAME$',
                ],
                [
                    // module
                    "{$folderModule}",
                    // namespace
                    "Modules\\{$folderModule}\\App\\Repositories\\{$modelName}",
                    // class
                    "{$modelName}RepositoryImplement",
                    // repository
                    "{$modelName}Repository",
                    // model
                    "Modules\\{$folderModule}\\App\\Models\\{$modelName}",
                    "{$modelName}",
                    // export
                    "\\Modules\\{$folderModule}\\App\\Exports\\{$modelName}Export",


                ],
                File::get($stubPath)
            );
            File::put($implementPath, $stubContent);

            $this->info("✅ Repository - {$modelName}RepositoryImplement created successfully.");
        } else {
            $this->warn("🚨 Repository -{$modelName}RepositoryImplement already exists.");
        }
    }

    protected function createServiceImplement($folderModule, $modelName, $SoftDelete)
    {
        $stubPath = $SoftDelete ? base_path("stubs/ServiceImplement.stub") : base_path("stubs/ServiceImplement-plain.stub");
        $implementPath = base_path("Modules/{$folderModule}/App/Services/{$modelName}/{$modelName}ServiceImplement.php");

        $this->createDirectory($implementPath);

        if (!File::exists($implementPath)) {
            $stubContent = str_replace(
                [
                    '$NAMESPACE$',
                    '$CLASS$',

                    '$RESOURCE_NAMESPACE$',
                    '$RESOURCE_NAME$',

                    '$REPOSITORY_NAMESPACE$',
                    '$MAIN_REPOSITORY$',

                    '$SERVICE_INTERFACE$',
                ],
                [
                    // namespace
                    "Modules\\{$folderModule}\\App\\Services\\{$modelName}",
                    "{$modelName}ServiceImplement",
                    // resource
                    "Modules\\{$folderModule}\\App\\Http\\Resources\\{$modelName}\\{$modelName}Resource",
                    "{$modelName}Resource",
                    // repository
                    "Modules\\{$folderModule}\\App\\Repositories\\{$modelName}\\{$modelName}Repository",
                    "{$modelName}Repository",
                    // service
                    "{$modelName}Service"


                ],
                File::get($stubPath)
            );
            File::put($implementPath, $stubContent);

            $this->info("✅ Service - {$modelName}ServiceImplement created successfully.");
        } else {
            $this->warn("🚨 Service - {$modelName}ServiceImplement already exists.");
        }
    }

    protected function createDirectory($path)
    {
        $directory = dirname($path);

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
        }
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
