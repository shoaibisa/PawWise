<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{

    protected $table = "addresses";

    // hasone relation

    use HasFactory;
    public function getcity(): HasOne
    {
        return $this->hasOne(City::class);
    }
    public function getcountry(): HasOne
    {
        return $this->hasOne(country::class);
    }
    public function getstate(): HasOne
    {
        return $this->hasOne(state::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
