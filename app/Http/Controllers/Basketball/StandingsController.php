<?php

namespace App\Http\Controllers\Basketball;


use App\Http\Controllers\Controller;
use function view;

class StandingsController extends Controller {

    // Retrieve function
    public function index() {

        $standings = '';

        return view('standings')->with(compact('standings'));

    }

}
