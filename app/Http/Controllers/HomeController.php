<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        if(Auth::user()->active == 1)
        return view('home');
        else return view('banned');
    }
}
