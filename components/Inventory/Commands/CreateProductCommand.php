<?php

namespace Italofantone\Inventory\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Italofantone\Inventory\Actions\CreateProduct;

#[Signature('inventory:create-product 
    {name : The name of the product}
')]
#[Description('Command to create a new product')]
class CreateProductCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(CreateProduct $action)
    {
        $product = $action->execute(
            name: $this->argument('name')
        );

        $this->info("Product ID #{$product->id}: '{$product->name}' created successfully.");

        return self::SUCCESS;
    }
}
