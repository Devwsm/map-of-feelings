<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pressconController extends Controller
{
    //
    public function landing(){
        return view('pages.presscon.landing');
    }
    
    public function guest(){
        return view('pages.presscon.guest');
    }
}