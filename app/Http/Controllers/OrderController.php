<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function order($order_group)
    {
        error_log("METHOD ORDER, order group:".$order_group);
        $orderSingle = Order::where('group', $order_group)->first();

        $orders = Order::where('group', $order_group)->get();
        $data_images = DB::table('image_parse')
        ->join('image', 'image_parse.image_id', '=', 'image.id')
        ->select('image_parse.*', 'image.image_location')
        ->where('image_parse.position', 1)  
        ->get();
        $data_items = Item::all();

        //return view('rule', compact('data_parameter','data_category','data_rule'));
        return view('order', compact( 'orderSingle', 'orders', 'data_images', 'data_items'));
    }

}
