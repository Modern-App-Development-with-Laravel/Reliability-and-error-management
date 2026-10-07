<?php

namespace Italofantone\Inventory\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Italofantone\Inventory\Actions\CreateMovement;
use Italofantone\Inventory\Enums\MovementType;
use Italofantone\Inventory\Exceptions\InsufficientStock;
use Italofantone\Inventory\Exceptions\InvalidQuantity;
use Italofantone\Inventory\Models\Product;

#[Signature('inventory:create-movement
    {--product= : The ID of the product}
    {--type= : The type of movement (in or out)}
    {--quantity= : The quantity to move}
')]
#[Description('Command to create a new inventory movement')]
class CreateMovementCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(CreateMovement $action)
    {
        $product = Product::findOrFail($this->option('product'));

        $type = MovementType::from($this->option('type'));

        $quantity = (int) $this->option('quantity');

        if ($quantity <= 0) {
            throw new InvalidQuantity(
                message: "Invalid quantity: {$quantity}. Quantity must be greater than zero."
            );
        }

        if ($type === MovementType::OUT && $quantity > $product->stock) {
            throw new InsufficientStock(
                availableStock: $product->stock,
                requestedQuantity: $quantity
            );
        }

        $movement = $action->execute(
            product: $product,
            type: $type,
            quantity: $quantity
        );

        $this->info("Movement ID #{$movement->id} created successfully.");
        $this->line("Product ID #{$product->id}: '{$product->name}' now has stock: {$product->stock}");

        return self::SUCCESS;
    }
}
