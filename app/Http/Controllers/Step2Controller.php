<?php

namespace App\Http\Controllers;

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


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Step2Controller extends Controller
{


    public function step2load(){


        error_log("METHOD step2load");
        $data_items_id=[];
        $cookie_data = [];
        $cart_items = [];
        $data_images = DB::table('image_parse')
        ->join('image', 'image_parse.image_id', '=', 'image.id')
        ->select('image_parse.*', 'image.image_location')
        ->where('image_parse.position', 1)  
        ->get();
        $data_rules = Rule::all();

        if (Auth::check()) {
            error_log("The user is logged in");
        
            $user_id = Auth::id();
            $cart_items = Cart::select('item_id', 'quantity')
            ->where('user_id', $user_id)
            ->get();
    
            $cart_items = $cart_items->pluck('quantity', 'item_id')->toArray();
            $item_ids = array_keys($cart_items);

            $query = DB::table('item')
                ->select('item.id as item_id', 'item.name', 'item.price', 'item.quantity', 'item.status');
        
            if (!empty($item_ids)) { 
                $query->whereIn('item.id', $item_ids); 
                $cookie_data = $query->get();
                $data_items_id = $item_ids; 
            }
        }
        
        else {
            error_log("The user is NOT logged in");
            $cart_items = json_decode(Cookie::get('cart_items', '[]'), true);
            
            $item_ids = array_keys($cart_items); 

            error_log("json encode item_Ids: ". json_encode($item_ids));
            error_log("json encode: ". json_encode($cart_items));
            
            $query = DB::table('item')
                ->select('item.id as item_id', 'item.name', 'item.price', 'item.quantity', 'item.status');
                //->where('status', '=', 1); 
            
            if (!empty($item_ids)) {
                $query->whereIn('item.id', $item_ids); 
                $cookie_data = $query->get();
                $data_items_id = $cookie_data->pluck('item_id')->toArray();

            }
            else {
                $cookie_data = [];
            }

            error_log("The user is NOT logged in" . json_encode($cookie_data));
        }
        error_log("cart items: " . json_encode($cookie_data));

        $data_specifications = Specification::whereIn('item_id', $data_items_id)
        ->join('parameter', 'specification.parameter_id', '=', 'parameter.id')
        ->join('value', 'specification.value_id', '=', 'value.id')
        ->join('item', 'specification.item_id', '=', 'item.id')
        ->join('category', 'item.category_id', '=', 'category.id') 
        ->select(
            'item.id as item_id',
            'item.name as item_name',
            'parameter.id as parameter_id',
            'parameter.parameter_name',
            'value.id as value_id',
            'value.value_name',
            'category.id as category_id',
            'category.category as category_name' 
        )
        ->get();
        

        return view('cart_step_2', compact('data_images','cart_items', 'cookie_data', 'data_rules', 'data_specifications')); // compact('data_parameter','data_category','data_rule'));
    }

    public function orderSubmit(Request $request)
    {
        error_log("METHOD ORDER SUBMIT");
        

        $validated = $request->validate([
            'name' => 'required|regex:/^[a-zA-ZĄĆĘĮĖŠąčęįėš\s]+$/',
            'lastname' => 'required|regex:/^[a-zA-ZĄĆĘĮĖŠąčęįėš\s]+$/',
            'email' => 'required|email',
            'country' => 'required',
            'phone' => 'required|regex:/^[0-9]{7,15}$/',
            'postcode' => 'required|digits_between:4,10',
            'address' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'The Name field is required.',
            'lastname.required' => 'The Last Name field is required.',
            'email.required' => 'The Email field is required.',
            'country.required' => 'The Country field is required.',
            'phone.required' => 'The Phone field is required.',
            'postcode.required' => 'The Postcode field is required.',
            'address.required' => 'The Address field is required.',
            'city.required' => 'The City field is required.',
            'name.regex' => 'The Name field can only contain letters and spaces.',
            'lastname.regex' => 'The Last Name field can only contain letters and spaces.',
            'phone.regex' => 'The Phone field must contain only digits and be between 7 and 15 digits.',
            'postcode.digits_between' => 'The Postcode field must be between 4 and 10 digits.',
        ]);


        $validated['name'] = ucfirst(strtolower($validated['name']));
        $validated['lastname'] = ucfirst(strtolower($validated['lastname']));

        error_log("Order Placed By: " . json_encode($validated));

        $group = Str::random(7);
        while (Order::where('group', $group)->exists()) {
            $group = Str::random(7);
        }
        $items=null;
        $user_id = -1;
        
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            error_log("user id: " . $user_id);

            $items = Cart::where('user_id', $user_id)
            ->select('quantity', 'item_id') 
            ->get();
            foreach ($items as $item) {
                // Find the price for the current item by item_id
                $itemData = Item::find($item->item_id);
        
                // If the item is found, add the price to the item
                if ($itemData) {
                    $item->price = $itemData->price;
                } else {
                    echo "price error";
                }
            }

        }
        else {
            // When the user is not logged in, get items from the cookies
            $cart_items = json_decode(Cookie::get('cart_items', '[]'), true);
            
            $items = [];
            foreach ($cart_items as $item_id => $quantity) {
                $items[] = [
                    'item_id' => $item_id,
                    'quantity' => $quantity
                ];
            }
            $item_ids = array_column($items, 'item_id'); 
            $item_prices = Item::whereIn('id', $item_ids)->get(['id', 'price'])->keyBy('id'); 
            // Add the price to each item in the $items array
            foreach ($items as &$item) {
                if (isset($item_prices[$item['item_id']])) {
                    $item['price'] = $item_prices[$item['item_id']]->price;
                }
            }
        }

        error_log("Items: " . json_encode($items));

        error_log("Items before loop: " . json_encode($items));


        $addedItemIds = [];
        foreach ($items as &$item) {
            if (in_array($item['item_id'], $addedItemIds)) {
                $existingItemKey = array_search($item['item_id'], array_column($items, 'item_id'));
                $items[$existingItemKey]['quantity'] += $item['quantity']; // Add quantities
                continue; 
            }
        

            error_log("Creating Order for item: " . json_encode($item));
        
            // Create the order
            Order::create([
                'group' => $group,
                'status' => 1,
                'user_id' => $user_id,
                'name' => $validated['name'],
                'lastname' => $validated['lastname'],
                'contact_phone' => $validated['phone'],
                'contact_email' => $validated['email'],
                'deliver_country' => $validated['country'],
                'deliver_postcode' => $validated['postcode'],
                'deliver_city' => $validated['city'],
                'deliver_address' => $validated['address'],
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        
            $addedItemIds[] = $item['item_id'];
        }
        
        error_log("Updated Items after processing: " . json_encode($items));
        
        
        

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
            'redirect_url' => route('order', ['order_group' => $group])  
        ], 200);

    }
    

}
