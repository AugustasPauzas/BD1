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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str; 



class MainController extends Controller
{   
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

            $data_specification = Specification::all(); // DELETE LATER if not needed

            $data_all_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.item_id', 'image_parse.position') // Also select item_id for reference
            ->get();

            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position') // Select image_parse.id as image_parse_id
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
            ->where('s.item_id', $item_id) 
            ->orderBy('p.parameter_name')
            ->get();

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
            return view('view_update', [ 'data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification,  'data_image' => $data_image, 'data_specifications_table' => $data_specifications_table]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }
    public function Live_reload_update_specification($itemId)
    {
        // Fetch the required data based on $itemId
        $data_item = Item::find($itemId);
        $data_specification = Specification::where('item_id', $itemId)->get(); // Adjust as per your logic
        $data_parameter = Parameter::all();
        $data_value = Value::all(); // Adjust according to your models
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

        // Return a partial view with the filtered data
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
    public function category_search($search_name){

    }
    public function category_unspec()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_item = Item::all();
        $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
        ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.item_id', 'image_parse.position') // Also select item_id for reference
        ->orderBy('position')->get();
    
        
        //error_log('aaa');

        return view('category', ['data_category' => $data_category, 'data_parameter' => $data_parameter, 'data_item' => $data_item, 'data_image'=> $data_image]);
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
        // Log the incoming request data
        error_log("FUNCTION ajax_update_specification_parameter, item id: " . $request->item_id);
        error_log("FUNCTION ajax_update_specification_parameter, par id: " . $request->parameter_id);
        error_log("FUNCTION ajax_update_specification_parameter, spec id: " . $request->specification_id);
        error_log("FUNCTION ajax_update_specification_parameter, name: " . $request->name);
    
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|integer',
            'parameter_id' => 'required|integer',
            'specification_id' => 'required|string|max:255',
        ]);
    
        // Parse the specification IDs into an array of integers
        $specificationIds = array_map('intval', array_map('trim', explode(',', $validatedData['specification_id'])));
        error_log("Parsed Specification IDs: " . implode(', ', $specificationIds));
    
        // Retrieve specifications with the parsed IDs
        $specifications = Specification::whereIn('id', $specificationIds)->get();
    
        // Find or create the parameter
        $parameterFound = Parameter::where('parameter_name', $validatedData['name'])->first();
        if ($parameterFound) {
            error_log("Parameter exists, reusing existing parameter.");
            $newParId = $parameterFound->id;
        } else {
            // Create a new parameter and get the new ID
            $newParameter = Parameter::create(['parameter_name' => $validatedData['name']]);
            $newParId = $newParameter->id;
            error_log("New Parameter created with ID: " . $newParId);
        }
    
        // Check if specifications were found
        if ($specifications->isNotEmpty()) {
            foreach ($specifications as $specification) {
                error_log("Updating Specification ID: " . $specification->id);
                $specification->parameter_id = $newParId; // Assign the new or existing parameter ID
                $specification->save(); // Save the updated specification
            }
    
            return response()->json(['message' => 'Specifications updated successfully.']);
        } else {
            // No specifications found
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
            'item_id' => 'required|integer',  // Ensure item_id exists and is valid
            'name' => 'required|string|max:255',              // Ensure name is a string and not too long
            'parameter_id' => 'required|integer', // Ensure parameter_id exists and is valid
        ]);

        $value = Value::where('value_name', $validatedData['name'])->first();

        if ($value) {
            error_log("value exist, reparsing");
            error_log("value exist, data: " . $value);
        } else {
            error_log("value does not exist, creating new value");
    
            // Add the name into validated data and create a new value
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
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
    
        // Validate the input
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
    
        // Check validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Save the new item to the database
        Item::create([
            'category_id' => $request->input('category'),
            'user_id' => 444, // or auth()->id(),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'ien_code' => $request->input('ien_code'),
            'quantity' => $request->input('quantity'),
        ]);
    
        // Return a successful response
        return response()->json(['message' => 'Item added successfully!'], 200);
    }
    public function ajax_update_item(Request $request)
    {
        error_log("FUNCTION ajax_update_item, id: ".$request->id);
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
    
        // Validate the input
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
    
        // Check validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Save the new item to the database
        $item = Item::find($request->id);
        $item->update([
            'category_id' => $request->input('category'),
            'user_id' => 444, // or auth()->id(),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'ien_code' => $request->input('ien_code'),
            'quantity' => $request->input('quantity'),
        ]);
    
        // Return a successful response
        return response()->json(['message' => 'Item added successfully!'], 200);
        
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

        // Calculate the hash before saving the file
        $temp_path = $file->getRealPath();
        $hash = hash_file('sha256', $temp_path);

        // Check if the hash exists
        $hash_exists = Image::where('hash', $hash)->first();

        if ($hash_exists) {
            // If hash exists, don't save the file again
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
            // If hash doesn't exist, save the file
            $filename = time() . '_' . str()->random() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/item');
            $file->move($path, $filename);

            // Now save the image details
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
    
            // Check if the previous position exists
            $primary_position_target = $primary->position - 1;
            $secondary_position_target = $primary->position;
    
            // Find the secondary image at the previous position
            $secondary = ImageParse::where('position', $primary_position_target)
                ->where('item_id', $item_id)
                ->first();
    
            if (!$secondary) {
                error_log('No secondary image found at position: ' . $primary_position_target);
                //return response()->json(['error' => 'No image found to the left.'], 404);B
                goto break_free_of_try;
            }
    
            // Swap the positions
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
    
            // Check if the next position exists
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
    
/*
    public function add_new_image($item_id, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:webp,jpg,jpeg,png,gif|max:25600',
            'position' => 'nullable|integer',
        ]);
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . str()->random() . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/item');
            $file->move($path, $filename);
            $hash = hash_file('sha256', $path . '/' . $filename);
            $hash_exists = Image::where('hash', $hash)->first();
    
            if ($hash_exists) {
                $the_image_id = $hash_exists->id; 
                ImageParse::create([
                    'item_id' => $item_id,
                    'image_id' => $the_image_id,
                    'position' => $request->input('position'),
                ]);
                $this->item_images_reorder();
                
    
                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully!',
                    'image' => $hash_exists,
                ]);
            } else {
                $image = Image::create([
                    'image_location' => 'images/item/' . $filename,
                    'hash' => $hash, 
                ]);
                $the_image_id = $image->id; 
                ImageParse::create([
                    'item_id' => $item_id,
                    'image_id' => $the_image_id,
                    'position' => $request->input('position'),
                ]);
            }
        }
    }
*/


    public function delete_image($item_id, $image_parse_id)
    {
        error_log('FUNCTION delete_image'); 
        // Retrieve the image_parse record
        $imageParse = ImageParse::find($image_parse_id);
        
        if (!$imageParse) {
            // Return a 404 response if the image is not found
            return response()->json(['error' => 'Image not found.'], 404);
        }
    
        // Delete the image_parse record
        $imageParse->delete();
    
        // Reorder images if necessary
        $this->item_images_reorder();
    
        // Retrieve the updated list of images
        $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
            ->orderBy('position')->get();
    
        // Return success and updated data as JSON
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
            'data' => $data_image
        ]);
        //TODO delete image if 0 in use
    }
    //----
    
    




    // Function only
    public function item_images_reorder()
    {
        $uniqueItemIds = ImageParse::distinct()->pluck('item_id');
        foreach ($uniqueItemIds as $uniqueItemId) {
            $images = ImageParse::where('item_id', $uniqueItemId)->orderBy('position')->get();
            $new_position = 1;
            foreach ($images as $img) {
                $update_target = ImageParse::find($img->id);
                if ($update_target->position !== $new_position) {
                    $update_target->position = $new_position;
                    $update_target->save();
                }
                $new_position++;
            }
        }
        //return response()->json(['status' => 'success', 'message' => 'Image positions reordered successfully.']);
        return;
    }
    public function language_parse($input_text)
    {   
        //TODO create language translator
        error_log( 'Parsing Text: '.$input_text);
        //$this->language_parse("test");
        
        $translater_text= "translated";
        return $translater_text;
    }
    public function remove_dublication_from_specification()
    {
        error_log('METHOD remove_dublication_from_specification');
        $data_specification = Specification::all();
        $uniqueSpecifications = [];
        foreach ($data_specification as $specification) {
            $key = $specification->item_id . '_' . $specification->value_id . '_' . $specification->parameter_id;
            if (isset($uniqueSpecifications[$key])) {
                //error_log('Deleting duplicate: ' . json_encode($specification));
                $specification->delete(); 
            } else {
                $uniqueSpecifications[$key] = $specification->id;
            }
        }
        return response()->json(['message' => 'Duplicate specifications removed successfully.']);
    }
    

    
        
    
}
