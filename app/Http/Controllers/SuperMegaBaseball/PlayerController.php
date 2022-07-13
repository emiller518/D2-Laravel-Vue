<?php

namespace App\Http\Controllers\SuperMegaBaseball;

use App\Http\Controllers\Controller;
use App\Repositories\SuperMegaBaseball\PlayerRepository;
use DB;

class PlayerController extends Controller
{

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function playerOverview(){
        $players = $this->playerRepository->getPlayerData();
        return view('smb')->with(compact('players'));
    }

}
