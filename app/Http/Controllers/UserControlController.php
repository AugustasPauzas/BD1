<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\User;


class UserControlController extends Controller
{
    //

    public function UserControl (){
        
        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 2) {
            return redirect('/login');        }

        //$user_id = Auth::id();

        $data_users = User::all();
        




        return view('users', compact('data_users'));
    }
}
