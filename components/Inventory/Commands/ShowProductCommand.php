<?php

namespace Italofantone\Inventory\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Italofantone\Inventory\Models\Product;

#[Signature('inventory:show-product
    {id : The ID of the product to show}
')]
#[Description('Command to show the details of a product')]
class ShowProductCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product = Product::with('movements')
            ->findOrFail($this->argument('id'));

        $this->info("Product ID #{$product->id}: '{$product->name}'");
        $this->line("Stock: {$product->stock}");

        if ($product->movements->isNotEmpty()) {
            $this->newLine();        

            $this->table(
                ['ID', 'Type', 'Quantity'],
                $product->movements->map(fn($movement) => [
                    $movement->id,
                    $movement->type->value,
                    $movement->quantity,
                ])->all()
            );
        }

        return self::SUCCESS;
    }
}
