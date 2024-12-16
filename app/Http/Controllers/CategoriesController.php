<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


use App\Models\Category;
use App\Models\Parameter;
use App\Models\Specification;
use App\Models\Value;
use App\Models\Item;
use App\Models\Image;
use App\Models\ImageParse;
use App\Models\Rule;
use App\Models\Cart;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{    
    
    public function Live_categories()
    {
        error_log("METHOD Live_categories");
        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 2) {
            return redirect('/login'); 
        }

        //echo "CONTROLLER WORKS";
        $data = Category::all();
        //$data = "bbbb";
        //return view('categories', ['data' => $data]);
        //return view('partials.Live_categories', compact('data'));

        return response()->json([
            'view' => view('partials.Live_categories', compact('data'))->render(),
            'message' => 'Categories Reloaded'
        ]);  


        /*return response()->json([
            'view' => view('partials.Live_cart', compact('data_images', 'cart_items', 'cookie_data', 'data_specifications', 'data_rules'))->render(),
            'message' => 'Item Cart Reloaded'
        ]);  
        */
 
        //return view('/categories'); 
    }
    /*
    public function update_category_name($category_id)
    {
        error_log("METHOD update_category_name");
        error_log("category_id: ".$category_id);
    }
    */


    public function add_new_category(Request $request){
        error_log("METHOD add_new_category");


        error_log("request: ". json_encode($request));

        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'category_full' => 'required|string|max:255',
        ]);
        $validatedData['status'] = 0;
        $validatedData['image_location'] = "";
    
        Category::create($validatedData);
        

        return response()->json(['message' => 'Category added successfully']);

    }



    public function update_category_name(Request $request)
    {
        //error_log("Request data: " . print_r($request->all(), true));
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
            'id' => 'required|integer',
        ]);
        //error_log("Validation passed.");
        $category = Category::find($validatedData['id']);
        if (!$category) {
            //error_log("Category not found.");
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->update(['category' => $validatedData['category_name']]);
        //error_log("Category updated successfully.");
    
        return response()->json(['message' => 'Category updated successfully']);
    }

    public function update_category_name_full(Request $request)
    {
        //error_log("Request data: " . print_r($request->all(), true));
        $validatedData = $request->validate([
            'category_name_full' => 'required|string|max:255',
            'id' => 'required|integer',
        ]);
        //error_log("Validation passed.");
        $category = Category::find($validatedData['id']);
        if (!$category) {
            //error_log("Category not found.");
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->update(['category_full' => $validatedData['category_name_full']]);
        //error_log("Category updated successfully.");
    
        return response()->json(['message' => 'Category updated successfully']);
    }

    
    public function category_status_set_active($category_id)
    {
        error_log("category_status_set_active");
        error_log("category id: ". $category_id);
        $category = Category::find($category_id);
        if ($category) {
            $category->status = 1;
            $category->save(); 

            return response()->json(['message' => 'Category status set to active']);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function category_status_set_inactive($category_id)
    {
        error_log("category_status_set_active");
        error_log("category id: ". $category_id);
        $category = Category::find($category_id);
        if ($category) {
            $category->status = 0;
            $category->save(); 

            return response()->json(['message' => 'Category status set to active']);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
    }
    

    public function category_set_image(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:12048',
            'id' => 'required|integer',
        ]);
    
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            
            $imageName = time() . '.' . $image->getClientOriginalExtension();
    
            $image->move(public_path('images/categoryImages'), $imageName);
    
            $category = Category::find($request->id);
            $category->image_location = 'images/categoryImages/' . $imageName;
            $category->save();
    
            return response()->json(['message' => 'Image uploaded successfully']);
        }
    
        return response()->json(['message' => 'Failed to upload image'], 400);
    }


}
