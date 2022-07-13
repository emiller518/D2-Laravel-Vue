<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class SMBEditorController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {



        return view('home');
    }
}
