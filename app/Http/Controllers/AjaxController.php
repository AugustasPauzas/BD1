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
use App\Models\Cart;




use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\Validator;


class AjaxController extends Controller
{
    //
    protected $FunctionController;
    public function __construct(FunctionController $otherController)
    {
        $this->FunctionController = $otherController;
        //usage
        //return $this->FunctionController->language_parse("text");
        //error_log ("translated: ".$this->FunctionController->language_parse("text"));
    }

    public function ajax_move_image_to_left($image_parse_id)
    {
        error_log('Entering ajax_move_image_to_left method with image_parse_id: ' . $image_parse_id);
    
        try {
            $this->FunctionController->item_images_reorder();
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
            //$this->item_images_reorder();
            $this->FunctionController->item_images_reorder();

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

                //$this->item_images_reorder();
                $this->FunctionController->item_images_reorder();

                $item_image_id_target = ImageParse::find($imageParse->id);
                error_log('t id: ' . $item_image_id_target);

                return response()->json([
                    'success' => true,
                    'message' => 'Image Added',
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

                //$this->item_images_reorder();
                $this->FunctionController->item_images_reorder();

                $item_image_id_target = ImageParse::find($imageParse->id);
                error_log('t position: ' . $item_image_id_target->position);


                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded',
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
    public function ajax_update_item(Request $request)
    {
        error_log("FUNCTION ajax_update_item, id: ".$request->id);
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'ien_code' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
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
            //'user_id' => 444, // TODO or auth()->id(),
            'status' => $request->input('status'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'ien_code' => $request->input('ien_code'),
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json([
            'message' => 'Item Updated'
        ]);        
        
        //error_log ("logging new id: ");
        //error_log ("logging new id: ".$item->id);

        //return response()->json(['item_id' => $item->id, 'message' => 'Item updated successfully!'], 200);


        //return response()->json(['message' => 'Item added successfully!'], 200);
    }

    public function ajax_add_new_item(Request $request)
    {
        error_log ("METHOD ajax_add_new_item");
        // Prepare price by converting ',' to '.'
        $request->merge(['price' => str_replace(',', '.', $request->input('price'))]);
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'ien_code' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
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
        $this->FunctionController->remove_dublication_from_specification();
        return response()->json(['message' => 'Specification added successfully']);
    //return response()->json(['error' => 'Fatal Error']);
    }

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
        return response()->json(['message' => 'Specifications Row Deleted Successfully']);
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

        $this->FunctionController->remove_dublication_from_specification();

        return response()->json(['message' => 'Value added successfully']);
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
                return response()->json(['success' => true, 'message' => 'Item Deleted'] ); // Return success
            } catch (\Exception $e) {
                error_log('Error deleting specification: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        //TODO REMOVE value from value table if not in use; same for parameter
    
        return response()->json(['success' => false, 'message' => 'No specification found to delete.']);
    }


    public function ajax_cart_increase_quantity($item_id) {
        error_log('METHOD ajax_cart_increase_quantity');
    
        if (Auth::check()) {
            error_log("The user is logged in");
            
            $user_id = Auth::id();
            
            // Find the cart item for the logged-in user
            $cartItem = Cart::where('user_id', $user_id)
                ->where('item_id', $item_id)
                ->first();
        
            if ($cartItem) {
                // Increase the quantity by 1
                $cartItem->quantity += 1; 
                $cartItem->save(); 
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item quantity increased successfully',
                    'new_quantity' => $cartItem->quantity 
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item not found in the cart',
                ]);
            }
        } 
        else {
            error_log("The user is NOT logged in");
    
            $cartItems = json_decode(Cookie::get('cart_items', '[]'), true) ?? [];
            
            if (isset($cartItems[$item_id])) {
                // Increase the quantity by 1
                $cartItems[$item_id] += 1;
            } else {
                // If the item doesn't exist in the cart, initialize it with quantity 1
                $cartItems[$item_id] = 1;
            }
    
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 48);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Item quantity increased successfully',
                'cart' => $cartItems,
            ]);
        }
    }
    
    public function ajax_cart_decrease_quantity($item_id) { 
        error_log('METHOD ajax_cart_decrease_quantity');
    
        if (Auth::check()) {
            error_log("The user is logged in");
            
            $user_id = Auth::id();

            $cartItem = Cart::where('user_id', $user_id)
                ->where('item_id', $item_id)
                ->first();
        
            if ($cartItem) {
                // Decrease the quantity by 1
                if ($cartItem->quantity > 1) {
                    $cartItem->quantity -= 1; 
                    $cartItem->save(); 
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Item quantity decreased successfully',
                        'new_quantity' => $cartItem->quantity 
                    ]);
                } else {
                    $cartItem->delete();
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Item removed from the cart successfully',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Item not found in the cart',
                ]);
            }
        } 
         else {
            error_log("The user is NOT logged in");
    
            $cartItems = json_decode(Cookie::get('cart_items', '[]'), true) ?? [];
            
            if (isset($cartItems[$item_id])) {
                // Decrease the quantity by 1
                $cartItems[$item_id] -= 1;
    
                // Remove the item if the quantity is zero or less
                if ($cartItems[$item_id] <= 0) {
                    unset($cartItems[$item_id]);
                }
            }
    
            // Queue the updated cart items in the cookie for 48 hours
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 48);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Item quantity decreased successfully',
                'cart' => $cartItems,
            ]);
        }
    }
    
    public function ajax_create_rule(Request $request) {
        error_log('METHOD ajax_create_rule');
        $validatedData = $request->validate([
            'category_id_1' => 'required|integer',
            'category_id_2' => 'required|integer',
            'operation'     => 'required|integer',
            'parameter_id_1'=> 'required|integer',
            'parameter_id_2'=> 'required|integer',
        ]);

        $existingRule = Rule::where('category_id_1', $validatedData['category_id_1'])
        ->where('category_id_2', $validatedData['category_id_2'])
        ->where('operation', $validatedData['operation'])
        ->where('parameter_id_1', $validatedData['parameter_id_1'])
        ->where('parameter_id_2', $validatedData['parameter_id_2'])
        ->first();

        if ($existingRule) {
            return response()->json(['message' => 'This rule already exists']); // HTTP 409 Conflict
        }

        $newEntry = Rule::create([
            'category_id_1'  => $validatedData['category_id_1'],
            'category_id_2'  => $validatedData['category_id_2'],
            'operation'      => $validatedData['operation'],
            'parameter_id_1' => $validatedData['parameter_id_1'],
            'parameter_id_2' => $validatedData['parameter_id_2'],
        ]);

       return response()->json(['message' => 'Rule added successfully', 'data' => $newEntry]);


    }

    public function ajax_delete_rule($rule_id) {
        error_log('METHOD ajax_delete_rule');

        $rule = Rule::find($rule_id);

        if (!$rule) {
            return response()->json(['message' => 'Rule not found']); // HTTP 404 Not Found
        }

        $rule->delete();

       return response()->json(['message' => 'Rule deleted successfully']);
    }




}
