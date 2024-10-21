<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $table = 'rule';
    protected $fillable = ['id','category_id_1', 'category_id_2', 'operation', 'parameter_id_1', 'parameter_id_2'];

}
