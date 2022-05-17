<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Season;
use App\Models\PlayerStats;
use App\Repositories\PlayerDataRepository;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Response;

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



}
