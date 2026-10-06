<?php

namespace Italofantone\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'stock',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }
}
