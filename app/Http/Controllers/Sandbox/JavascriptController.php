<?php

namespace App\Http\Controllers\Sandbox;

use App\Http\Controllers\Controller;
use DB;
use function view;

class JavascriptController extends Controller {

    // Retrieve function
    public function index() {

        return view('javascript');

    }

}
