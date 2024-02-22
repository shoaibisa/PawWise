<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
 use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    protected $table = "transactions";
    public $timestamps = true;

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class,'sender_id');
    }
    public function receiver():BelongsTo {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function bank():BelongsTo {
        return $this->belongsTo(User::class,'bank_id');
    }
    protected $fillable = [
        'amount',
     
        'receiver_id',
        'sender_id'

    ];
 
    use HasFactory;
}
