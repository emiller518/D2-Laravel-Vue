<?php

namespace App\Http\Controllers\Basketball;

use App\Http\Controllers\Controller;
use App\Models\Basketball\Game;
use App\Models\Basketball\PlayerStats;
use App\Repositories\Basketball\PlayByPlayRepository;
use DB;
use function collect;
use function view;


class GamesController extends Controller {

    public function __construct(PlayByPlayRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    // Retrieve function
    public function index($id) {

        $GameStats = Game::query()
            ->where('GameID', '=', intval($id))
            ->first();

        $PlayerStats = PlayerStats::query()
        ->select("PlayerStats.*", "Game.GameID", "Game.SeasonID", "Player.*", "PlayerYear.*", "Class.Abbreviation",
            DB::RAW("CASE WHEN Game.HomeID = PlayerYear.TeamID THEN 'H' ELSE 'A' END 'team'"))
        ->leftJoin('Game', 'Game.GameID', '=', 'PlayerStats.GameID')
        ->leftJoin('Player', 'Player.PlayerID','=', 'PlayerStats.PlayerID')
        ->leftJoin('PlayerYear', 'PlayerYear.PlayerID', '=', 'Player.PlayerID')
        ->leftJoin('Team', 'Team.TeamID', '=', 'PlayerYear.TeamID')
        ->leftJoin('Class', 'Class.ClassID', '=', 'PlayerYear.ClassID')
        ->where('PlayerYear.SeasonID', '=', intval($GameStats->SeasonID))
        ->where('PlayerStats.GameID', '=', intval($id))
        ->orderBy(DB::RAW("CASE WHEN Game.HomeID = PlayerYear.TeamID THEN 'H' ELSE 'A' END asc, PlayerStats.Starter desc,
                           CASE WHEN PlayerStats.Starter = 1 THEN (Case WHEN PlayerYear.Position = 'G' then 2 WHEN PlayerYear.Position = 'F' then 1 else 0 end)
                           WHEN PlayerStats.Starter = 0 then PlayerStats.Minutes end"), 'desc')
        ->get();

        $HomePlayerStats = collect();
        $AwayPlayerStats = collect();

        foreach ($PlayerStats as $Player){
            if ($Player->team == 'A'){
                $AwayPlayerStats->push($Player);
            }
            else{
                $HomePlayerStats->push($Player);
            }
        }

        return view('game')->with(compact('GameStats', 'HomePlayerStats', 'AwayPlayerStats'));
    }

}
