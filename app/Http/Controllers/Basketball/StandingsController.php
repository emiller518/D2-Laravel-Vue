<?php

namespace App\Http\Controllers;


class StandingsController extends Controller {

    // Retrieve function
    public function index() {

        $standings = '';

        return view('standings')->with(compact('standings'));

    }

}
