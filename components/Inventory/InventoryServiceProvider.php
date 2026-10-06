<?php

namespace Italofantone\Inventory;

use Illuminate\Support\ServiceProvider;
use Italofantone\Inventory\Commands\CreateMovementCommand;
use Italofantone\Inventory\Commands\CreateProductCommand;
use Italofantone\Inventory\Commands\ShowProductCommand;

class InventoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');        

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateMovementCommand::class,
                CreateProductCommand::class,
                ShowProductCommand::class,
            ]);
        }
    }
}