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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;


class LiveController extends Controller
{
    public function Live_reload_update_specification($itemId)
    {
        $data_item = Item::find($itemId);
        $data_specification = Specification::where('item_id', $itemId)->get(); 
        $data_parameter = Parameter::all();
        $data_value = Value::all(); 
        $data_specifications_table = DB::table('specification as s')
        ->join('parameter as p', 's.parameter_id', '=', 'p.id')
        ->join('value as v', 's.value_id', '=', 'v.id')
        ->select(
            's.id as specification_id',
            's.item_id',
            's.parameter_id',
            'p.parameter_name',
            's.value_id',
            'v.value_name'
        )
        ->where('s.item_id', $itemId) 
        ->orderByDesc('s.id')
        ->get();


        return view('partials.Live_specifications', compact('data_item', 'data_specification', 'data_parameter', 'data_value', 'data_specifications_table'));
    }


    public function Live_view_update_big_pick($item_id) {
        $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
        ->where('image_parse.item_id', $item_id)
        ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
        ->orderBy('position')->get();
        return view('partials.Live_view_update_big_pick', compact('data_image'));
    }

    public function Live_reload_all_images($item_id)
    {
        error_log('FUNCTION Live_reload_all_images');
        try {
            $data_item = Item::findOrFail($item_id);

            $data_parameter = Parameter::all();
            $data_category = Category::all();
            $data_value = Value::all();
            $data_specification = Specification::all();
            //$data_image_parse = ImageParse::where('item_id', $item_id)->get();
            //$data_image = Image::all();
            //$item_id = 1;
            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
            ->orderBy('position')->get();

            return view('partials.Live_images_reload', [ 'data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification, 'data_image' => $data_image]); 
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        } catch (\Exception $e) {
            error_log($e);
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function Live_specification_add_form($item_id) {
        error_log("METHOD Live_specification_add_form, Item ID: " . $item_id);
        $data_item = Item::findOrFail($item_id);
        // Loading DROP DOWN here
        $data_specifications_table_all_items = DB::table('specification as s')
            ->join('parameter as p', 's.parameter_id', '=', 'p.id')
            ->join('value as v', 's.value_id', '=', 'v.id')
            ->join('item as i', 's.item_id', '=', 'i.id') 
            ->select(
                's.parameter_id',      
                'p.parameter_name',
                'i.category_id'
            )
            ->where('i.category_id', $data_item->category_id)
            ->whereNotIn('s.parameter_id', function($query) use ($item_id) {
                $query->select('s.parameter_id')
                      ->from('specification as s')
                      ->where('s.item_id', $item_id);
            })
            ->distinct()
            ->orderBy('p.parameter_name')
            ->get();
    
        error_log("Data Specifications: " . json_encode($data_specifications_table_all_items)); // Check the data
    
        return view('partials.Live_specification_add_form', compact('data_item', 'data_specifications_table_all_items'));
    }

    public function Live_cart() {
        error_log("METHOD Live_cart");
        
        if (Auth::check()) {
            error_log("The user is logged in");
            // Handle logged-in user cart items here if needed
        } else {
            error_log("The user is NOT logged in");
            
            // Get cart items from cookie
            $cart_items = json_decode(Cookie::get('cart_items', '[]'), true) ?? [];
            $item_ids = array_keys($cart_items); // Use keys for item IDs
            
            error_log("json encode: " . json_encode($cart_items));
            
            $data_images = DB::table('image_parse')
                ->join('image', 'image_parse.image_id', '=', 'image.id')
                ->select('image_parse.*', 'image.image_location')
                ->where('image_parse.position', 1)
                ->get();
    
            $query = DB::table('item')
                ->select('item.id as item_id', 'item.name', 'item.price', 'item.quantity', 'item.status');
            
            if (!empty($item_ids)) {
                $query->whereIn('item.id', $item_ids); // Filter by item IDs in the cart
            }
            
            $cookie_data = $query->get();
            
            error_log("The user is NOT logged in: " . json_encode($cookie_data));
            
            // Return view with cart items and images
            return response()->json([
                'view' => view('partials.Live_cart', compact('data_images', 'cart_items', 'cookie_data'))->render(),
                'message' => 'Item Cart Reloaded'
            ]);        }
    }
    public function Live_rule() {
        error_log("METHOD Live_cart");
        
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_rule = Rule::all();
        // Return view with cart items and images
        return response()->json([
            'view' => view('partials.Live_rule', compact('data_parameter', 'data_category', 'data_rule'))->render(),
            'message' => 'Rules Reloaded'
        ]);        
    }
    
    
}
