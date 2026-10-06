<?php

namespace Italofantone\Inventory\Actions;

use Italofantone\Inventory\Enums\MovementType;
use Italofantone\Inventory\Models\Movement;
use Italofantone\Inventory\Models\Product;

class CreateMovement
{
    public function execute(Product $product, MovementType $type, int $quantity): Movement
    {
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