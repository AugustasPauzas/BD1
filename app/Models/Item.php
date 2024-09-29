<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    //public $timestamps = false; // added after
    protected $table = 'item';
    protected $fillable = ['id','category_id', 'user_id', 'name', 'description', 'price', 'ien_code', 'quantity', 'status'];

}
