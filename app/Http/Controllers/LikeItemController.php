<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\LikeItem;

use Illuminate\Http\Request;

class LikeItemController extends Controller
{
    public function view_like ()
    {

        error_log("METHOD add_like");
        
        if (Auth::check()) {
            error_log("The user logged in");
            //TODO
            return view('liked_items', []);
        }
        else {
            return redirect('/register');//->with('error', 'must register first.');
        }

    }
    public function add_like ($item_id)
    {
        error_log("METHOD add_like; item id:". $item_id);
        
        if (Auth::check()) {
            error_log("The user logged in");
        
            $user_id = Auth::id();
            $item_id ; 
    

            $like = LikeItem::where('user_id', $user_id)->where('item_id', $item_id)->first();
    
            if ($like) {
                // If it exists, delete the like
                $like->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item unliked successfully!'
                ]);
            } else {
                // If it doesn't exist, create a new like
                LikeItem::create([
                    'item_id' => $item_id,
                    'user_id' => $user_id
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Item liked successfully!'
                ]);
            }
        }
        else {
            return redirect('/register');//->with('error', 'must register first.');
        }

    }
}
