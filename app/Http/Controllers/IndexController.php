<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function returnIndex ()
    {

        $data_category = Category::all();
        $data_item = Item::all()->sortByDesc('id');
        $data_image = DB::table('image_parse')
        ->join('image', 'image_parse.image_id', '=', 'image.id')
        ->select('image_parse.*', 'image.image_location')
        ->where('image_parse.position', 1)  // Add this line to filter by position
        ->get();


        return view('index', compact('data_item','data_category', 'data_image'));
    }
}
