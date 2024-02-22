<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class state extends Model
{
    protected $table = 'states';
    public $timestamps = true;
    protected $fillable = [
        'name'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(country::class);
    }
    use HasFactory;
}
