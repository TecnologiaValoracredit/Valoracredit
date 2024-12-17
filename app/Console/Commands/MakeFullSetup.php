<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeFullSetup extends Command
{
    protected $signature = 'make:fullsetup {name}';
    protected $description = 'Create a model, controller, request, datatable and seeder';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');

        // Crear el modelo con migración
        Artisan::call('make:model', ['name' => $name, '--migration' => true]);
        $this->info("Model $name created with migration.");

        // Crear el controlador de recursos
        $controllerName = $name . 'Controller';
        Artisan::call('make:controller', ['name' => $controllerName, '--resource' => true]);
        $this->info("Controller $controllerName created.");

        // Crear la request
        $requestName = $name . 'Request';
        Artisan::call('make:request', ['name' => $requestName]);
        $this->info("Request $requestName created.");

        // Crear el DataTable (suponiendo que tienes Yajra DataTables instalado)
        $dataTableName = $name . 'DataTable';
        Artisan::call('datatables:make', ['name' => $dataTableName]);
        $this->info("DataTable $dataTableName created.");

        $seeder = $name . 'Seeder';
        Artisan::call('make:seeder', ['name' => $seeder]);
        $this->info("Seeder $seeder created.");

        return 0;
    }
}
