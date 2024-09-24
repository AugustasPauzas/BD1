<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageParse extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'image_parse';
    protected $fillable = ['id','item_id','image_id','position'];
}
