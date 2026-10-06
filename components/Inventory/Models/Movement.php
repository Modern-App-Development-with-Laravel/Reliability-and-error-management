<?php

namespace Italofantone\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Italofantone\Inventory\Enums\MovementType;

class Movement extends Model
{
    protected $fillable = [
        'type',
        'quantity',
    ];

    protected $casts = [
        'type' => MovementType::class,
    ];
}
