<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;

class AppController extends Controller {

    public function home(){

        return view('home');

    }//home

    public function logout(){

        Auth::logout();

        return redirect()->route('home');

    }//logout

}//AppController
