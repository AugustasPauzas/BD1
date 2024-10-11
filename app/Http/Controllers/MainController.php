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

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
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

    public function view_item($item_id)
    {
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
    public function cart()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_value = Value::all();
        $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
        ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.item_id', 'image_parse.position') // Also select item_id for reference
        ->get();
        
        return view('cart', ['data_category' => $data_category, 'data_parameter' => $data_parameter, 'data_value' => $data_value, 'data_image'=> $data_image]);
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

    public function ajax_update_view_delete_value(Request $request)
    {
        $value_id = $request->input('value_id'); 
        $specification_id = $request->input('specification_id'); 
        error_log('Function ajax_update_view_delete_value SPECIFICATION ID: ' . $specification_id);
        error_log('Function ajax_update_view_delete_value, Value ID: ' . $value_id);
        //$delete_specification = Specification::where('value_id', $value_id)->whereIn('id', $specification_id);
        //$delete_specification = Specification::where('id', $specification_id);
        $delete_specification = Specification::where('id', $specification_id);
        error_log('Function ajax_update_view_delete_value, DELETING 1: ' . $delete_specification->get());

        if ($delete_specification->exists()) {
            error_log('Deleting NOW');
            try {
                $delete_specification->delete(); 
                error_log('Deleted');
                return response()->json(['success' => true]); // Return success
            } catch (\Exception $e) {
                error_log('Error deleting specification: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        //TODO REMOVE value from value table if not in use; same for parameter
    
        return response()->json(['success' => false, 'message' => 'No specification found to delete.']);
    }
    
    
    
    //---
    //TABLE PARAMETER
    public function add_new_parameter(Request $request){
        $validatedData = $request->validate([
            'parameter_name' => 'required|string|max:255'
        ]);
    
        Parameter::create($validatedData);
        return redirect('/specifications'); 
    }
    public function ajax_update_specification_parameter(Request $request)
    {
        error_log("FUNCTION ajax_update_specification_parameter, item id: " . $request->item_id);
        error_log("FUNCTION ajax_update_specification_parameter, par id: " . $request->parameter_id);
        error_log("FUNCTION ajax_update_specification_parameter, spec id: " . $request->specification_id);
        error_log("FUNCTION ajax_update_specification_parameter, name: " . $request->name);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|integer',
            'parameter_id' => 'required|integer',
            'specification_id' => 'required|string|max:255',
        ]);
        $specificationIds = array_map('intval', array_map('trim', explode(',', $validatedData['specification_id'])));
        error_log("Parsed Specification IDs: " . implode(', ', $specificationIds));
        $specifications = Specification::whereIn('id', $specificationIds)->get();
        $parameterFound = Parameter::where('parameter_name', $validatedData['name'])->first();
        if ($parameterFound) {
            error_log("Parameter exists, reusing existing parameter.");
            $newParId = $parameterFound->id;
        } else {
            $newParameter = Parameter::create(['parameter_name' => $validatedData['name']]);
            $newParId = $newParameter->id;
            error_log("New Parameter created with ID: " . $newParId);
        }
        if ($specifications->isNotEmpty()) {
            foreach ($specifications as $specification) {
                error_log("Updating Specification ID: " . $specification->id);
                $specification->parameter_id = $newParId; 
                $specification->save(); 
            }
            return response()->json(['message' => 'Specifications updated successfully.']);
        } else {
            return response()->json(['message' => 'Specifications not found.'], 404);
        }
    }
    
    //TABLE SPECIFICATION
    public function ajax_delete_specification_row(Request $request)
    {
        error_log("ajax_delete_specification_row, item id: " . $request->item_id);
        error_log("ajax_delete_specification_row, parameter id: " . $request->parameter_id);
        error_log("ajax_delete_specification_row, specification id: " . $request->specification_id);
        $specifications = Specification::where('parameter_id', $request->parameter_id)->where('item_id', $request->item_id)->get();
        error_log("ajax_delete_specification_row, DATA2: " . $specifications);
        foreach ($specifications as $specification) {
            $specification->delete();
        }
    
        return response()->json(['message' => 'Specifications deleted successfully']);
    }

    public function ajax_add_only_value_form (Request $request){
        error_log("ajax_add_only_value_form, itemid: ".$request->item_id);
        error_log("ajax_add_only_value_form, value name: ".$request->name);
        error_log("ajax_add_only_value_form, parameter: ".$request->parameter_id);

        $validatedData = $request->validate([
            'item_id' => 'required|integer',  
            'name' => 'required|string|max:255',             
            'parameter_id' => 'required|integer',
        ]);

        $value = Value::where('value_name', $validatedData['name'])->first();

        if ($value) {
            error_log("value exist, reparsing");
            error_log("value exist, data: " . $value);
        } else {
            error_log("value does not exist, creating new value");
            $validatedData['value_name'] = $validatedData['name']; 
            $value = Value::create($validatedData);
        }

        Specification::create([
            'item_id' =>  $validatedData['item_id'],
            'value_id' => $value->id,
            'parameter_id' =>  $validatedData['parameter_id']
        ]);

        $this->remove_dublication_from_specification();

        return response()->json(['message' => 'Value added successfully']);
    }

    public function ajax_add_specification(Request $request){

        error_log("FUNCTION ajax_add_specification, id: ".$request->item_id);
        error_log("FUNCTION ajax_add_specification, par name: ".$request->parameter_name);
        error_log("FUNCTION ajax_add_specification, val name: ".$request->value_name);
        $validatedData = $request->validate([
            'value_name' => 'required|string|max:255',
            'parameter_name' => 'required|string|max:255'
        ]);

        $parameter = Parameter::where('parameter_name',  $validatedData['parameter_name'])->first();
        if ($parameter){
            error_log("Parameter exist, reparsing");
        }
        else{
            $parameter = Parameter::create($validatedData);
        }
        
        $value = Value::where('value_name',  $validatedData['value_name'])->first();
        if ($value){
            error_log("value exist, reparsing");
        }
        else{
            $value = value::create($validatedData);          
        }
        
        Specification::create([
            'item_id' => $request->input('item_id'),
            'value_id' => $value->id,
            'parameter_id' => $parameter->id
        ]);
        $this->remove_dublication_from_specification();
        return response()->json(['message' => 'Specification added successfully']);


    //return response()->json(['error' => 'Fatal Error']);
    }
    //---
    public function specifications(){

        $value_data = Value::all();
        $parameter_data = Parameter::all();
        $specification_data  = Specification::all();
        return view('specifications', ['value_data' => $value_data,'parameter_data' => $parameter_data,'specification_data' => $specification_data]);
    }
    //---TABLE ITEM
    public function ajax_add_new_item(Request $request)
    {
        error_log ("METHOD ajax_add_new_item");
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'ien_code' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0|max:999999',
            'category' => 'required|string',
        ], [
            'name.required' => 'Item Name Field Is Required',
            'ien_code.required' => 'IEN Code Field Is Required',
            'price.required' => 'Price Field Is Required',
            'status.required' => 'Valid Status Is Required',
            'description.required' => 'Description Field Is Required',
            'quantity.required' => 'Quantity Field Is Required',
            'category.required' => 'Valid Category Is Required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = Item::create([
            'category_id' => $request->input('category'),
            'user_id' => 444, // TODO or auth()->id(),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'ien_code' => $request->input('ien_code'),
            'quantity' => $request->input('quantity'),
        ]);
        error_log ("logging new id: ");
        error_log ("logging new id: ".$item->id);
        //$this->view_item($item->id);
        return response()->json(['item_id' => $item->id, 'message' => 'Item updated successfully!'], 200);

        //return response()->json(['message' => 'Item added successfully!'], 200);
    }
    public function ajax_update_item(Request $request)
    {
        error_log("FUNCTION ajax_update_item, id: ".$request->id);
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'ien_code' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0|max:999999',
            'category' => 'required|string',
        ], [
            'name.required' => 'Item Name Field Is Required',
            'ien_code.required' => 'IEN Code Field Is Required',
            'price.required' => 'Price Field Is Required',
            'status.required' => 'Valid Status Is Required',
            'description.required' => 'Description Field Is Required',
            'quantity.required' => 'Quantity Field Is Required',
            'category.required' => 'Valid Category Is Required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = Item::find($request->id);
        $item->update([
            'category_id' => $request->input('category'),
            'user_id' => 444, // TODO or auth()->id(),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'ien_code' => $request->input('ien_code'),
            'quantity' => $request->input('quantity'),
        ]);


        //error_log ("logging new id: ");
        //error_log ("logging new id: ".$item->id);

        //return response()->json(['item_id' => $item->id, 'message' => 'Item updated successfully!'], 200);


        //return response()->json(['message' => 'Item added successfully!'], 200);
    }
    
//---
// TABLE IMAGE
public function ajax_item_image_upload(Request $request)
{
    error_log('FUNCTION ajax_item_image_upload'); 
    $request->validate([
        'item_id' => 'integer',
        'image' => 'required|image|mimes:webp,jpg,jpeg,png,gif|max:25600',
        'position' => 'nullable|integer',
    ]);

    if ($request->hasFile('image')) {
        $file = $request->file('image');

        $temp_path = $file->getRealPath();
        $hash = hash_file('sha256', $temp_path);

        $hash_exists = Image::where('hash', $hash)->first();

        if ($hash_exists) {
            $the_image_id = $hash_exists->id;
            $imageParse = ImageParse::create([
                'item_id' => $request->input('item_id'),
                'image_id' => $the_image_id,
                'position' => $request->input('position')
            ]);

            $this->item_images_reorder();

            $item_image_id_target = ImageParse::find($imageParse->id);
            error_log('t id: ' . $item_image_id_target);

            return response()->json([
                'success' => true,
                'message' => 'Image already exists!',
                'image' => [
                    'image_parse_id' => $imageParse->id,
                    'image_location' => $hash_exists->image_location,
                    'position' => $item_image_id_target->position,
                    'parse_id' => $item_image_id_target->id,
                    'item_id' => $request->input('item_id')
                ],
            ]);
        } else {
            $filename = time() . '_' . str()->random() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/item');
            $file->move($path, $filename);

            $image = Image::create([
                'image_location' => 'images/item/' . $filename,
                'hash' => $hash,
            ]);

            $imageParse = ImageParse::create([
                'item_id' => $request->input('item_id'),
                'image_id' => $image->id,
                'position' => $request->input('position')
            ]);

            $this->item_images_reorder();
            $item_image_id_target = ImageParse::find($imageParse->id);
            error_log('t position: ' . $item_image_id_target->position);


            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'image' => [
                    'image_parse_id' => $imageParse->id,
                    'image_location' => $image->image_location,
                    'position' => $item_image_id_target->position,
                    'item_id' => $item_image_id_target->item_id
                ],
            ]);
        }
    }
    error_log("bad File");
}

    public function ajax_move_image_to_left($image_parse_id)
    {
        error_log('Entering ajax_move_image_to_left method with image_parse_id: ' . $image_parse_id);
    
        try {
            $this->item_images_reorder();
            error_log('FUNCTION move_image_to_left');
    
            $primary = ImageParse::findOrFail($image_parse_id);
            $item_id = $primary->item_id;

            $primary_position_target = $primary->position - 1;
            $secondary_position_target = $primary->position;
    
            $secondary = ImageParse::where('position', $primary_position_target)
                ->where('item_id', $item_id)
                ->first();
    
            if (!$secondary) {
                error_log('No secondary image found at position: ' . $primary_position_target);
                //return response()->json(['error' => 'No image found to the left.'], 404);B
                goto break_free_of_try;
            }
    
            $secondary->position = $secondary_position_target;
            $secondary->save();
    
            $primary->position = $primary_position_target;
            $primary->save();
    
            //return response()->json(['success' => 'Image moved left successfully.']);
        } catch (\Exception $e) {
            error_log('Error in ajax_move_image_to_left: ' . $e->getMessage());
            //return response()->json(['error' => 'An error occurred while moving the image.'], 500);
        }
        break_free_of_try:
    }
    
    public function ajax_move_image_to_right($image_parse_id)
    {
        error_log('Entering ajax_move_image_to_right method with image_parse_id: ' . $image_parse_id);
    
        try {
            $this->item_images_reorder();
            error_log('FUNCTION move_image_to_right'); 
    
            $primary = ImageParse::findOrFail($image_parse_id);
            $item_id = $primary->item_id;
    
            $primary_position_target = $primary->position + 1;
            $secondary_position_target = $primary->position;
    
            $secondary = ImageParse::where('position', $primary_position_target)
                ->where('item_id', $item_id)
                ->first();
    
            if (!$secondary) {
                error_log('No secondary image found at position: ' . $primary_position_target);
                //return response()->json(['error' => 'No image found to the right.'], 404);
                goto break_free_of_try;
            }
    
            $secondary->position = $secondary_position_target;
            $secondary->save();
    
            $primary->position = $primary_position_target;
            $primary->save();
    
            return response()->json(['success' => 'Image moved right successfully.']);
        } catch (\Exception $e) {
            error_log('Error in ajax_move_image_to_right: ' . $e->getMessage());
            //return response()->json(['error' => 'An error occurred while moving the image.'], 500);
        }
        break_free_of_try:
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
