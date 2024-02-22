<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeEditor extends Model
{
    protected $table = "code_editors";
    protected $fillable = [
        'code'
    ];
    use HasFactory;
}
