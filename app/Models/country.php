<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class country extends Model
{
    protected $table = 'countries';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];

    use HasFactory;
    public function states(): HasMany
    {
        return $this->hasMany(state::class);
    }
    // getting all cities in a country
    public function getAllCity(): HasManyThrough
    {
        return $this->hasManyThrough(City::class, state::class);
    }
}
