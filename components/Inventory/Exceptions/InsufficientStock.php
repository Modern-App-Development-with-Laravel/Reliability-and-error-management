<?php

namespace Italofantone\Inventory\Exceptions;

use RuntimeException;

class InsufficientStock extends RuntimeException
{
    public function __construct(
        int $availableStock,
        int $requestedQuantity,
    ) {
        $message = "Insufficient stock: available {$availableStock}, requested {$requestedQuantity}.";
        
        parent::__construct($message);
    }
}