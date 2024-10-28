<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
    use HasFactory;
    protected $table = 'item';
    protected $fillable = ['id','category_id', 'user_id', 'name', 'description', 'price', 'ien_code', 'quantity', 'status'];

    public function getFormattedPriceAttribute()
    {
        return '€' . number_format($this->price, 2);
    }
}
