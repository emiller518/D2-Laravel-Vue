<?php

namespace App\Http\Controllers\Basketball;

use App\Http\Controllers\Controller;
use App\Repositories\Basketball\PlayerDataRepository;
use DB;
use function view;

class PlayerController extends Controller {

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

    public function playerData($id): array
    {
        $playerData = [];
        $PlayerGameLog = $this->playerDataRepository->getPlayerGameLog($id);
        $playerSeasonStatsPer30 = $this->playerDataRepository->getPlayerSeasonStatsPer30($id);
        $playerSeasonStats = $this->playerDataRepository->getPlayerSeasonStats($id);
        $playerProfile = $this->playerDataRepository->getPlayerProfile($id);

        $playerData['gameLogs']=$PlayerGameLog;
        $playerData['playerSeasonStats']=$playerSeasonStats;
        $playerData['playerSeasonStatsPer30']=$playerSeasonStatsPer30;
        $playerData['playerProfile'] = $playerProfile;

        return ($playerData);
    }


    public function playerProfile($id) {
        return view('player')->with(compact('id'));
    }

}
