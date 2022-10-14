<?php

namespace App\Http\Controllers\API;

use App\Factories\JsonAPIResponseFactory;
use App\Repositories\SuperMegaBaseball\PlayerRepository;
use App\Repositories\SuperMegaBaseball\LeagueRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class SMBEditorController extends Controller
{
    /**
     * @var PlayerRepository
     * @var LeagueRepository
     * @var Request
     */
    private $playerRepository;

    /**
     * @param PlayerRepository $playerRepository
     * @param LeagueRepository $leagueRepository
     * @param Request $request
     */
    public function __construct(PlayerRepository $playerRepository, LeagueRepository $leagueRepository, Request $request){
        $this->playerRepository = $playerRepository;
        $this->leagueRepository = $leagueRepository;
        $this->request          = $request;
    }

    public function updateStats($playerID): bool{
        $optionKey = $this->request->get('optionKey');
        $optionValue = $this->request->get('optionValue');

        $this->playerRepository->updateStats($playerID, $optionKey, $optionValue);
        return TRUE;

    }

    public function updateVisuals($playerID): bool{
        $optionKey = (int)$this->request->get('optionKey');
        $optionValue = (string)$this->request->get('optionValue');

        $this->playerRepository->updateVisuals($playerID, $optionKey, $optionValue);
        return TRUE;
    }

    public function getLeagues(): array {
        return $this->leagueRepository->getLeagues();
    }

    public function getTeams($league): array {
        return $this->leagueRepository->getTeamsInLeague($league);
    }

    public function getPlayers($team): Collection {
        return $this->playerRepository->getPlayerData($team);
    }

}
