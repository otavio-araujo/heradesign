<?php

namespace App\Models;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedstockSupplier extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'preco',
    ];

    protected $casts = [
        'preco' => 'integer',
    ];

    protected function preco(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2, ',', '.'),
            set: fn ($value) => ($value * 100),
        );
    }

}
