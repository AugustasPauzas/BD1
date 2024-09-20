<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'specification';
    protected $fillable = ['id','parameter_id','value_id','item_id'];
}
