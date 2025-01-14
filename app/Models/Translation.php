<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;
    protected $table = 'translation';
    protected $fillable = ['id','language_id','original_text','translated_text','status'];

}
