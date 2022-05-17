<?php

namespace App\Http\Controllers;

use App\Models\Game;


class StandingsController extends Controller {

    // Retrieve function
    public function index() {

        $standings = '';

        return view('standings')->with(compact('standings'));

    }

}
