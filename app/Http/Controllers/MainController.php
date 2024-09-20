<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Parameter;
use App\Models\Specification;
use App\Models\Value;


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
    public function category_unspec()
    {
        $data_parameter = Parameter::all();
        $data_category = Category::all();
        return view('category', ['data_category' => $data_category], ['data_parameter' => $data_parameter]);
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
    
}
