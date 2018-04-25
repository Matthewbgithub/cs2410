<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Gate;

class UserController extends Controller
{
    //
    public function user($id){
        $user = User::find($id);
        return view('/user', array('user' => $user));
    }
    public function list() {
        return view('/user', array('users'=>User::all()));
    }
    
}