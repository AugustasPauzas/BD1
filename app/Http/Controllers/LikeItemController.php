<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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
            //TODO
            return redirect('/like-item');
        }
        else {
            return redirect('/register');//->with('error', 'must register first.');
        }

        
    }
}
