<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Parameter;
use App\Models\Specification;
use App\Models\Value;
use App\Models\Item;
use App\Models\Image;
use App\Models\ImageParse;
use App\Models\Rule;
use App\Models\Cart;
use App\Models\LikeItem;
use App\Models\Order;

class OrdersController extends Controller
{
    //
    public function Orders ()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user_id = Auth::id();

        $data_orders = Order::where('user_id', $user_id)->get();
        $data_images = DB::table('image_parse')
        ->join('image', 'image_parse.image_id', '=', 'image.id')
        ->select('image_parse.*', 'image.image_location')
        ->where('image_parse.position', 1) 
        ->get();
        $data_items = Item::all();
        $unique_groups = $data_orders->pluck('group')->unique()->values()->all();



        return view('orders', compact('data_orders','unique_groups', 'data_images'));
    }
}
