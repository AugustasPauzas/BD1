<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FunctionController;


use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Parameter;
use App\Models\Specification;
use App\Models\Value;
use App\Models\Item;
use App\Models\Image;
use App\Models\ImageParse;
use App\Models\Rule;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


use Illuminate\Support\Str; 






class MainController extends Controller
{   
    protected $FunctionController;
    public function __construct(FunctionController $otherController)
    {
        $this->FunctionController = $otherController;
        //usage
        //return $this->FunctionController->language_parse("text");
        //error_log ("translated: ".$this->FunctionController->language_parse("text"));
        

    }

    public function rule(){
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_rule = Rule::all();
        return view('rule', compact('data_parameter','data_category','data_rule'));
    }

    public function view_item($item_id){
        try {

            $data_item = Item::findOrFail($item_id); 

            $data_all_item = Item::all()->filter(fn($item) => $item->id !== (int)$item_id);
            $data_all_item = $data_all_item->filter(fn($item) => $item->category_id === $data_item->category_id);
            $data_all_item = $data_all_item->shuffle()->take(6);


            $data_parameter = Parameter::all();
            $data_category = Category::all();
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
                ->where('s.item_id', $item_id) 
                ->orderBy('p.parameter_name')
                ->get();

            $data_specification = Specification::all(); //TODO DELETE LATER if not needed

            $data_all_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.item_id', 'image_parse.position') 
            ->get();

            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position') 
            ->orderBy('position')->get();
            
            //$data_specification = Specification::findOrFail($item_id);
            
            //echo $data_item;
            //echo $data_specification;
            return view('view', ['data_item' => $data_item,'data_all_item' => $data_all_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification,'data_all_image' => $data_all_image, 'data_image' => $data_image, 'data_specifications_table' => $data_specifications_table]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            echo "Fatal Error, Item Not Found";
            //return redirect('/category')->with('error', 'Item not found.');
        }
    }
    public function view_item_update ($item_id)
    {
        try {
            $data_item = Item::findOrFail($item_id);

            $data_parameter = Parameter::all();
            $data_category = Category::all();
            $data_value = Value::all();
            $data_specification = Specification::all();

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
            ->where('s.item_id', $item_id)->orderByDesc('s.id')->get();


            //loading DROP DOWN here
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
            //Drop down done



            //$data_image_parse = ImageParse::where('item_id', $item_id)->get();
            //$data_image = Image::all();
            //$item_id = 1;
            //dd($data_parameter);
            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
            ->orderBy('position')->get();


            //dd($data_image); 
            
            //$data_image = Image::all();
            //$data_specification = Specification::findOrFail($item_id);
            
            //echo $data_item;
            //echo $data_specification;
            return view('view_update', [ 'data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification,  'data_image' => $data_image, 'data_specifications_table' => $data_specifications_table, 'data_specifications_table_all_items' => $data_specifications_table_all_items]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }


    public function categories()
    {
        //echo "CONTROLLER WORKS";
        $data = Category::all();
        //$data = "bbbb";
        return view('categories', ['data' => $data]); 
        //return view('/categories'); 
    }
    public function create()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_value = Value::all();


        return view('create', ['data_category' => $data_category, 'data_parameter' => $data_parameter, 'data_value' => $data_value]);
    }

    public function remove_item_from_cart($item_id)
    {
        error_log("METHOD remove_item_from_cart");
        
        if (Auth::check()) {
            error_log("The user logged in");
            // NOTE change for live controller 2
            // TODO: Handle logic for logged-in users (if needed)
        } else {
            error_log("The user is NOT logged in");
    
            // Get cart items from the cookie
            $cartItems = json_decode(Cookie::get('cart_items', '[]'), true) ?? [];
    
            // Check if the item exists in the cart and remove it
            if (isset($cartItems[$item_id])) {
                unset($cartItems[$item_id]);
            }
    
            // Queue the updated cart items in the cookie for 48 hours
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 48);
    
            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Item removed successfully',
            ]);
        }
    }
    public function add_item_too_cart_no_quan($item_id)
    {
        if (Auth::check()) {
            error_log("The user is logged in");
            //TODO

        } 
        else {
            error_log("The user is NOT logged in");
        
            // Retrieve cart items from cookies
            $cartItems = json_decode(Cookie::get('cart_items', '[]'), true);
        
            if (isset($cartItems[$item_id])) {
                $cartItems[$item_id] += $cartItems[$item_id] + 1;
            } else {
                $cartItems[$item_id] = 1;
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24);
            return redirect('/cart');
        }

    }


    public function add_item_too_cart($item_id, Request $request)
    {
        /*
        try {
            $data_item = Item::findOrFail($item_id); 
            $data_item_all = Item::all(); 
            return view('cart', ['data_item' => $data_item]);
        } 
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            echo "Fatal Error, Item Not Found";
        }*/
        $validator = Validator::make(
            [
                'view_item_add_quantity' => $request->input('view_item_add_quantity')
            ], 
            [
                'view_item_add_quantity' => 'required|integer|min:1'
            ]
        );

        if ($validator->fails()) {
            error_log("Invalid quantity: " . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator);
        }
        $quantity = (int)$request->input('view_item_add_quantity');


        if (Auth::check()) {
            error_log("The user is logged in");
            //TODO

        } 
        else {
            error_log("The user is NOT logged in");
        
            // Retrieve cart items from cookies
            $cartItems = json_decode(Cookie::get('cart_items', '[]'), true);
        
            if (isset($cartItems[$item_id])) {
                $cartItems[$item_id] += $quantity;
            } else {
                $cartItems[$item_id] = $quantity;
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24);
            return redirect('/cart');
        }

    }

    public function cart()
    {

        error_log("METHOD cart");
        $data_items_id=[];
        $cookie_data = [];
        $cart_items = [];
        $data_images = DB::table('image_parse')
        ->join('image', 'image_parse.image_id', '=', 'image.id')
        ->select('image_parse.*', 'image.image_location')
        ->where('image_parse.position', 1)  // Add this line to filter by position
        ->get();
        $data_rules = Rule::all();

        if (Auth::check()) {
            error_log("The user is logged in");

        } 
        else {
            error_log("The user is NOT logged in");
            $cart_items = json_decode(Cookie::get('cart_items', '[]'), true);
            
            $item_ids = array_keys($cart_items); // Use keys for item IDs
            
            error_log("json encode: ". json_encode($cart_items));
            
            $query = DB::table('item')
                ->select('item.id as item_id', 'item.name', 'item.price', 'item.quantity', 'item.status');
                //->where('status', '=', 1); 
            
            if (!empty($item_ids)) {
                $query->whereIn('item.id', $item_ids); // Filter by item IDs in the cart
                $cookie_data = $query->get();
                $data_items_id = $cookie_data->pluck('item_id')->toArray();

            }
            else {
                $cookie_data = [];
            }

            //error_log("The user is NOT logged in" . json_encode($cookie_data));
        }
        //error_log("cart rules:" . $data_rules);
        error_log("cart items: " . json_encode($cookie_data));
        //error_log("ids only: " . json_encode($data_items_id));

        $data_specifications = Specification::whereIn('item_id', $data_items_id)
        ->join('parameter', 'specification.parameter_id', '=', 'parameter.id')
        ->join('value', 'specification.value_id', '=', 'value.id')
        ->join('item', 'specification.item_id', '=', 'item.id')
        ->join('category', 'item.category_id', '=', 'category.id') // Join category table with item table
        ->select(
            'item.id as item_id',
            'item.name as item_name',
            'parameter.id as parameter_id',
            'parameter.parameter_name',
            'value.id as value_id',
            'value.value_name',
            'category.id as category_id',
            'category.category as category_name' // Assuming 'category' column holds the name
        )
        ->get();

        


        return view('cart', compact('data_images','cart_items', 'cookie_data', 'data_rules', 'data_specifications'));

    }

    public function category_spec($category_name_or_id)
    {

        //error_log("All Query Parameters: " . json_encode(request()->query()));
        $filterArray = request()->query('fa', []); 
        error_log("Raw Filter array: " . json_encode($filterArray)); 
        if (!is_array($filterArray)) {
            $filterArray = [$filterArray]; 
        }
        //error_log("Filter array: " . json_encode($filterArray));
        $filters = [];
        foreach ($filterArray as $filter) {
            if (is_string($filter) && strpos($filter, ':') !== false) {
                list($parameterId, $valueId) = explode(':', $filter);
                $filters[] = [
                    'parameter_id' => $parameterId,
                    'value_id' => $valueId,
                ];
            }
        }

        //Looking for scr option
        $searchTerm = request()->query('src'); 


        // DONT DELETE function too call FA
        /*
        foreach ($filters as $filter) {
            error_log("Filter parameter ID: " . $filter['parameter_id']);
            error_log("Filter value ID: " . $filter['value_id']);
        }*/

        try {

            error_log('METHOD category_spec');
            error_log('METHOD category_spec category_name_or_id: ' . $category_name_or_id);
        
            // Check if minPrice and maxPrice are in the request
            $minPrice = request()->query('minPrice');
            $maxPrice = request()->query('maxPrice');

            $data_category = Category::all();
            $data_category_all = Category::where('id', $category_name_or_id)->get();
        
            if ($data_category_all->isEmpty()) 
            {
                error_log('No category found for ID: ' . $category_name_or_id);
                $data_category_all = Category::where('category', $category_name_or_id)->get();
            }
    
            $data_parameter = Parameter::all();
            
            // Filter items based on category and price range

            if ($category_name_or_id == "all_items"){
                error_log('all items loading');
                $data_item_all_category = Item::all();
                $data_item = Item::when($minPrice, function($query) use ($minPrice) {
                    return $query->where('price', '>=', $minPrice);
                })
                ->when($maxPrice, function($query) use ($maxPrice) {
                    return $query->where('price', '<=', $maxPrice);
                })
                ->get();
            }
            else
            {
                error_log('getting all category items loading');
                $data_item_all_category = Item::where('category_id', $data_category_all->first()->id)->get();

                $data_item = Item::where('category_id', $data_category_all->first()->id)
                ->when($minPrice, function($query) use ($minPrice) {
                    return $query->where('price', '>=', $minPrice);
                })
                ->when($maxPrice, function($query) use ($maxPrice) {
                    return $query->where('price', '<=', $maxPrice);
                })
                ->get();
            }
            //$data_item_all_category = Item::all();
            
            if (empty($filterArray)) {
                error_log("Filter Is Empty skipping " );
                $filtered_items = $data_item; 
            }
            else{
                error_log("Filter not empty, Working " );
                $data_items = DB::table('item') // Use 'item' as defined in your model
                ->join('specification', 'item.id', '=', 'specification.item_id') // Join condition
                ->select('item.*') // Select all columns from item
                ->when(!empty($filters), function ($query) use ($filters) {
                    // Loop through each filter and add where conditions
                    $query->where(function ($subQuery) use ($filters) {
                        foreach ($filters as $filter) {
                            if (isset($filter['value_id']) && isset($filter['parameter_id'])) {
                                // Add a where clause to filter by both parameter_id and value_id
                                $subQuery->orWhere(function ($innerQuery) use ($filter) {
                                    $innerQuery->where('specification.value_id', $filter['value_id'])
                                            ->where('specification.parameter_id', $filter['parameter_id']);
                                });
                            }
                        }
                    });
                })
                ->distinct('item.id') // Ensure distinct item IDs
                ->get();
                foreach ($filters as $filter) {
                    error_log("Filter parameter ID: " . $filter['parameter_id']);
                    error_log("Filter value ID: " . $filter['value_id']);
                }
                error_log("FINAL Filtered Items: " . json_encode($data_items));
                $data_item_ids = $data_item->pluck('id'); 
                $filtered_items = $data_items->whereIn('id', $data_item_ids);
                $filtered_items = $filtered_items->values(); 
            }

            /*$item_only_parameters = DB::table('item')
            ->join('specification', 'item.id', '=', 'specification.item_id')
            ->select('item.category_id', 'specification.parameter_id', 'specification.value_id')
            ->whereIn('item.id', $data_item->pluck('id'))  // Assuming $data_item is a collection
            ->get();*/
            //error_log('METHOD parameters:'. $item_only_parameters );
            $item_filter_parameters = DB::table('item')
            ->join('specification', 'item.id', '=', 'specification.item_id')
            ->join('parameter', 'specification.parameter_id', '=', 'parameter.id')
            ->join('value', 'specification.value_id', '=', 'value.id')
            ->select('item.category_id', 'specification.parameter_id', 'specification.value_id', 'parameter.parameter_name',  'value.value_name')
            ->whereIn('item.id', $data_item_all_category->pluck('id'))
            ->distinct()  // values are unique
            ->orderBy('parameter.parameter_name')
            ->get();
        
            error_log("all items: " . json_encode($filtered_items));
            if ($searchTerm) {
                error_log("Filtering By Search Name: " . json_encode($searchTerm));
            
                // Filter items based on similarity in 'name' or 'description' fields
                $filtered_items = $filtered_items->filter(function ($item) use ($searchTerm) {
                    return stripos($item->name, $searchTerm) !== false || stripos($item->description, $searchTerm) !== false;
                });
            
                // Log the filtered items
                error_log("Filtered Items: " . json_encode($filtered_items));
            } else {
                error_log("No Search Option by name, skipping");
            }

            //error_log('METHOD parameters:'. $item_filter_parameters );
    
            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
                ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.item_id', 'image_parse.position') 
                ->orderBy('position')->get();
    
            return view('category', [
                'data_category' => $data_category,
                'data_parameter' => $data_parameter,
                'data_item' => $filtered_items,
                'data_image' => $data_image,
                'specified_category_id_or_name' => $category_name_or_id,
                'data_item_all_category' =>$data_item_all_category,
                'item_filter_parameters' => $item_filter_parameters,
                'filter_array' => $filters,
                'search_term' => $searchTerm
            ]);
        } catch (\Exception $e) {
            error_log('Error in category_spec: ' . $e->getMessage());
            echo "no such category";
        }
    }
    
    
    public function category($category)
    {
        //return $category;
        $data_category = Category::all();
        return view('category', ['category' => $category, 'data_category' => $data_category]);
    }
    public function add_new_category(Request $request){
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'category_full' => 'required|string|max:255',
        ]);
    
        Category::create($validatedData);
        
        return redirect('/categories'); 
    }
    //TABLE VALUE
    public function add_new_value(Request $request){
        $validatedData = $request->validate([
            'value_name' => 'required|string|max:255'
        ]);
    
        Value::create($validatedData);
        return redirect('/specifications'); 
    }


    public function add_new_parameter(Request $request){
        $validatedData = $request->validate([
            'parameter_name' => 'required|string|max:255'
        ]);
    
        Parameter::create($validatedData);
        return redirect('/specifications'); 
    }

    public function specifications(){

        $value_data = Value::all();
        $parameter_data = Parameter::all();
        $specification_data  = Specification::all();
        return view('specifications', ['value_data' => $value_data,'parameter_data' => $parameter_data,'specification_data' => $specification_data]);
    }

    public function delete_image($item_id, $image_parse_id)
    {
        error_log('FUNCTION delete_image'); 
        $imageParse = ImageParse::find($image_parse_id);
        
        if (!$imageParse) {
            // Return a 404 response if the image is not found
            return response()->json(['error' => 'Image not found.'], 404);
        }

        $imageParse->delete();
        $this->item_images_reorder();
        $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
            ->orderBy('position')->get();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
            'data' => $data_image
        ]);
        //TODO delete image if 0 in use
    }
    //----
    //LEGACY SUPPORT
    public function item_images_reorder()
    {return $this->FunctionController->item_images_reorder();}
    public function remove_dublication_from_specification()
    {return $this->FunctionController->remove_dublication_from_specification();}
    
}
