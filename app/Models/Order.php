<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $fillable = ['id','name', 'lastname','group', 'status', 'user_id', 'contact_phone', 'contact_email', 'deliver_country', 'deliver_postcode', 'deliver_city', 'deliver_address', 'item_id', 'quantity', 'price'];

}
