<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class UserRoleController extends Controller
{
    //


    public function User_Change_To_Blocked ($user_id){
        error_log('METHOD User_Change_To_Regular');
        error_log('user id:'.$user_id);
        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 2) {
            return redirect('/login');        
        }
        //$data_users = User::all();
        $user = User::find($user_id);
        if ($user) {
            $user->level = -1;
            $user->save();
        } else {
            error_log('user not found:'.$user_id);
        }

        return response()->json(['message' => 'Role Changed successfully']);

    }

    public function User_Change_To_Regular ($user_id){
        

        error_log('METHOD User_Change_To_Regular');
        error_log('user id:'.$user_id);

        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 2) {
            return redirect('/login');        
        }

        $user = User::find($user_id);
        if ($user) {
            $user->level = 1;
            $user->save();
        } else {
            error_log('user not found:'.$user_id);
        }

        return response()->json(['message' => 'Role Changed successfully']);

    }
    public function User_Change_To_Administrator ($user_id){
        

        error_log('METHOD User_Change_To_Administrator');
        error_log('user id:'.$user_id);

        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 3) {
            return redirect('/login');        
        }

        $user = User::find($user_id);
        if ($user) {
            $user->level = 2;
            $user->save();
        } else {
            error_log('user not found:'.$user_id);
        }
        //$data_users = User::all();

        return response()->json(['message' => 'Role Changed successfully']);

    }

    public function User_Change_To_Owner ($user_id){
        

        error_log('METHOD User_Change_To_Administrator');
        error_log('user id:'.$user_id);
        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 3) {
            return redirect('/login');        
        }

        $users = User::where('level', 3)->get(); 

        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $user->level = 2;
                $user->save(); 
            }
        } else {
            error_log('No users found with level 3');
        }


        $user = User::find($user_id);
        if ($user) {
            $user->level = 3;
            $user->save();
        } else {
            error_log('user not found:'.$user_id);
        }
        //$data_users = User::all();

        return response()->json(['message' => 'Role Changed successfully']);

    }


    public function Live_User_List (){
        error_log('METHOD Live_User_List');

        //ADMIN CHECK
        if (!Auth::check()) {
            return redirect('/login');
        }
        if (Auth::user()->level < 2) {
            return redirect('/login');        
        }
        $data_users = User::all();

        return response()->json([
            'view' => view('partials.Live_user_list', compact('data_users'))->render(),
            'message' => 'Item Cart Reloaded'
        ]); 

        //return view('users', compact('data_users'));
    }
}
