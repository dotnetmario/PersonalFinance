<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SinglePageController extends Controller
{
    /**
     * Single page view
     * 
     * route => web (any)
     */
    public function index() {
        return view('app');
    }
}
