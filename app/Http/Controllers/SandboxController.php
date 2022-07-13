<?php

namespace App\Http\Controllers;

use App\Repositories\Basketball\PlayerDataRepository;
use DB;

class SandboxController extends Controller {
    /**
     * @var PlayerDataRepository
     */
    private $playerDataRepository;

    /**
     * @param PlayerDataRepository $playerDataRepository
     */
    public function __construct(PlayerDataRepository $playerDataRepository)
    {
        $this->playerDataRepository = $playerDataRepository;
    }

    // Retrieve function
    public function todo() {

        return view('sandbox/todo');

    }

    public function js() {
        error_log('hello');

        return view('sandbox/javascript');

    }

    public function vue($id) {
        return view('sandbox/vue')->with(compact('id'));

    }

    // Retrieve function
    public function vuechartjs() {

        return view('sandbox/vuechartjs');

    }

    // Retrieve function
    public function chartjs() {

        return view('sandbox/chartjs');

    }

    // Retrieve function
    public function d3() {

        return view('sandbox/d3');

    }




}
