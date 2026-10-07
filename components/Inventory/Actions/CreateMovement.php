<?php

namespace Italofantone\Inventory\Actions;

use Italofantone\Inventory\Enums\MovementType;
use Italofantone\Inventory\Exceptions\InsufficientStock;
use Italofantone\Inventory\Exceptions\InvalidQuantity;
use Italofantone\Inventory\Models\Movement;
use Italofantone\Inventory\Models\Product;

class CreateMovement
{
    public function execute(Product $product, MovementType $type, int $quantity): Movement
    {
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

        $movement = $product->movements()->create([
            'type' => $type,
            'quantity' => $quantity,
        ]);
        
        $product->update([
            'stock' => $product->stock + ($type === MovementType::IN ? $quantity : -$quantity)
        ]);

        return $movement;
    }
}