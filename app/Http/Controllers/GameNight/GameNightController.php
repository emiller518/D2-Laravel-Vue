<?php

namespace App\Http\Controllers\GameNight;

use App\Http\Controllers\Controller;
use App\Repositories\GameNight\GameNightRepository;

class GameNightController extends Controller
{

    /**
     * @var GameNightRepository
     */
    private $gameNightRepository;

    /**
     * @param GameNightRepository $gameNightRepository
     */
    public function __construct(GameNightRepository $gameNightRepository)
    {
        $this->gameNightRepository = $gameNightRepository;
    }

    public function home(){
        $players = ''; # $this->playerRepository->getPlayerData();
        return view('gamenight.home')->with(compact('players'));
    }

    public function admin(){
        $players = ''; # $this->playerRepository->getPlayerData();
        return view('gamenight.admin')->with(compact('players'));
    }

    public function getPlayers(){
        $players = $this->gameNightRepository->getAllPlayers();
        return view('gamenight.players')->with(compact('players'));
    }

    public function getPlayer($id){
        $accolades = $this->gameNightRepository->getPlayerAccolades($id);
        $matches = $this->gameNightRepository->getPlayerMatches($id);
        $overview = $this->gameNightRepository->getPlayerOverview($id);
        return view('gamenight.player')->with(compact('accolades','matches', 'overview'));
    }

    public function getGames(){
        return view('gamenight.games');
    }

    public function getGame($gameName){
        return view('gamenight.game')->with(compact('gameName'));
    }

    public function getMatches(){

        return view('gamenight.matches');
    }

    public function getMatch($id){
        $matches = $this->gameNightRepository->getAllMatches();
        return view('gamenight.match')->with(compact('matches'));
    }

    public function getSession($date){
        return view('gamenight.session')->with(compact('date'));
    }

}
