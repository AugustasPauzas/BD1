<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeItem extends Model
{
    use HasFactory;
    protected $table = 'like_item';
    protected $fillable = ['id','item_id', 'user_id'];
    
}
