<?php

namespace Italofantone\Inventory\Actions;

use Italofantone\Inventory\Models\Product;

class CreateProduct
{
    public function execute(string $name): Product
    {
        return Product::create(['name' => $name]);
    }
}