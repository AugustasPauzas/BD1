<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Category;


class MainController extends Controller
{
    public function categories()
    {
        //echo "CONTROLLER WORKS";
        $data = Category::all();
        //$data = "bbbb";
        return view('categories', ['data' => $data]); 
        //return view('/categories'); 
    }
    public function category($category)
    {
        //return $category;
        return view('category', ['category' => $category]);
    }
    public function add_new_category(Request $request){
        $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'category_full' => 'required|string|max:255',
        ]);
    
        Category::create($validatedData);
        
        return redirect('/categories'); // Redirect to the categories page
    }
    
}
