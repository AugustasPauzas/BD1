<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'parameter';
    protected $fillable = ['id','parameter_name'];
}
