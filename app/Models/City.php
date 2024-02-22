<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class City extends Model
{
    protected $table = "cities";

    public function state(): BelongsTo
    {
        return $this->belongsTo(state::class);
    }

    public function countryDetails(): HasManyThrough
    {
        return $this->hasManyThrough(country::class, state::class);
    }
    use HasFactory;
}
