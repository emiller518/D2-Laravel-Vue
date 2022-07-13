<?php

namespace App\Http\Controllers\SuperMegaBaseball;

use App\Http\Controllers\Controller;
use DB;

class SMBController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = DB::connection('sqlite')->select();
    }
}
