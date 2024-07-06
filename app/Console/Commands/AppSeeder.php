<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppSeeder extends Command
{
    protected $signature = 'app:seeder {moduleName} {modelName}';
    protected $description = 'Create a seeder for a specific model';

    public function handle()
    {
        $moduleName = $this->argument('moduleName');
        $modelName = $this->argument('modelName');
    }
}
