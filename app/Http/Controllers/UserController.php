<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
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
    public function home(){
        return view('userHome');
    }
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect('/participated-sports');
        }
        return redirect('/user-home');
      }
}
