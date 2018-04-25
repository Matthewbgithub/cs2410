<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('organizer')){
            return view('dashboard');
        }else{
            return view('register');
        }
    }
}
