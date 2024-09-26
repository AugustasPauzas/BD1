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
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str; 



class MainController extends Controller
{   
    public function view_item($item_id)
    {
        try {
            $data_item = Item::findOrFail($item_id);

            $data_parameter = Parameter::all();
            $data_category = Category::all();
            $data_value = Value::all();
            $data_specification = Specification::all();
            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position') // Select image_parse.id as image_parse_id
            ->orderBy('position')->get();
            //$data_specification = Specification::findOrFail($item_id);
            
            //echo $data_item;
            //echo $data_specification;
            return view('view', ['data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification, 'data_image' => $data_image]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            echo "Fatal Error";
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
            //$data_image_parse = ImageParse::where('item_id', $item_id)->get();
            //$data_image = Image::all();
            //$item_id = 1;
            $data_image = Image::join('image_parse', 'image.id', '=', 'image_parse.image_id')
            ->where('image_parse.item_id', $item_id)
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position')
            ->orderBy('position')->get();


            //dd($data_image); 
            
            //$data_image = Image::all();
            //$data_specification = Specification::findOrFail($item_id);
            
            //echo $data_item;
            //echo $data_specification;
            return view('view_update', [ 'data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification, 'data_image' => $data_image]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        }
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
    //---
    //TABLE PARAMETER
    public function add_new_parameter(Request $request){
        $validatedData = $request->validate([
            'parameter_name' => 'required|string|max:255'
        ]);
    
        Parameter::create($validatedData);
        return redirect('/specifications'); 
    }
    //---
    public function specifications(){

        $value_data = Value::all();
        $parameter_data = Parameter::all();
        $specification_data  = Specification::all();
        return view('specifications', ['value_data' => $value_data,'parameter_data' => $parameter_data,'specification_data' => $specification_data]);
    }
    //---TABLE ITEM
        public function add_new_item(Request $request)
        {
            // "," -> "."
            $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
        
            $request->validate([
                'name' => 'required|string|max:255',
                'ien_code' => 'required|string|max:255',
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/', // 4.44 4,44 4,4 4.4
                'status' => 'required|integer',
                'description' => 'required|string',
                'quantity' => 'required|integer',
                'category' => 'required|integer',
            ]);
        
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
        
            return redirect('/category');
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
    


    
        
    
}
