<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2, ',', '.'),
        );
    }
}
