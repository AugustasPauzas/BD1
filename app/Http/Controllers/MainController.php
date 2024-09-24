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
            ->get();
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
            ->select('image.*', 'image_parse.id as image_parse_id', 'image_parse.position') // Select image_parse.id as image_parse_id
            ->get();
        

            //dd($data_image); 
            
            //$data_image = Image::all();
            //$data_specification = Specification::findOrFail($item_id);
            
            //echo $data_item;
            //echo $data_specification;
            return view('view_update', ['data_item' => $data_item, 'data_parameter' => $data_parameter, 'data_category' => $data_category, 'data_value' => $data_value, 'data_specification' => $data_specification, 'data_image' => $data_image]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            echo "Fatal Error";
            //return redirect('/category')->with('error', 'Item not found.');
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
        return view('create', ['data_category' => $data_category], ['data_parameter' => $data_parameter], ['data_value' => $data_value]);
    }
    public function cart()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_value = Value::all();
        return view('cart', ['data_category' => $data_category], ['data_parameter' => $data_parameter], ['data_value' => $data_value]);
    }
    public function category_unspec()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        $data_item = Item::all();
        error_log('aaa');

        return view('category', ['data_category' => $data_category, 'data_parameter' => $data_parameter, 'data_item' => $data_item]);
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
    public function add_new_image(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:25600',
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
                echo "Image Already Exists";
                $the_image_id = $hash_exists->id; 
                ImageParse::create([
                    'item_id' => $request->input('item_id'),
                    'image_id' => $the_image_id,
                    'position' => $request->input('position'),  
                ]);
                return redirect()->back()->with('success', 'Image uploaded successfully!');
            } else {
                $image = Image::create([
                    'image_location' => 'images/item/' . $filename,
                    'hash' => $hash, 
                ]);
                $the_image_id = $image->id; 
                ImageParse::create([
                    'item_id' => $request->input('item_id'),
                    'image_id' => $the_image_id,
                    'position' => $request->input('position'), 
                ]);
            }
            return redirect()->back()->with('success', 'Image uploaded successfully!');
        }
        return redirect()->back()->with('error', 'Image upload failed.');
    }
    public function delete_image($image_parse_id)
    {
        // Retrieve the image_parse record
        $imageParse = ImageParse::find($image_parse_id);

        $imageParse->delete();
        /*
        if ($imageParse) {
            // Optionally delete the image file from storage
            $image = Image::find($imageParse->image_id);
            if ($image) {
                // Assuming the images are stored locally, delete the file
                // Storage::delete($image->file_path); // Uncomment if file deletion is needed
                $image->delete(); // Delete the image from the database
            }

            // Delete the record from image_parse table
            $imageParse->delete();

            return redirect()->back()->with('success', 'Image deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Image not found');
        }*/
        return redirect()->back()->with('success', 'Image deleted successfully');
    }
    //----
    
    
    
        
    
}
