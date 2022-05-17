<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Season;
use App\Models\PlayerStats;
use Illuminate\Http\Request;
use DB;

class JavascriptController extends Controller {

    // Retrieve function
    public function index() {

        return view('javascript');

    }

}
