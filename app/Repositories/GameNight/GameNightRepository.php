<?php

namespace App\Repositories\GameNight;

use App\Models\GameNight\Accolade;
use App\Models\GameNight\MatchInstance;
use App\Models\GameNight\Player;
use Illuminate\Support\Facades\DB;

class GameNightRepository
{
    public function getAllMatches()
    {
        return MatchInstance::query()
            ->get();
    }

    public function getAllPlayers()
    {
        return Player::query()
            ->get();
    }

    public function getPlayerInfo(){

    }

    public function getPlayerAccolades($playerId){
        return Accolade::query()
            ->selectRaw('Game.Name as GameName, AccoladeType.Name as AccoladeName, sum(Accolade.TimesReceived) TimesReceived, Icon')
            ->leftJoin('AccoladeType', 'Accolade.AccoladeTypeID', '=', 'AccoladeType.AccoladeTypeID')
            ->leftJoin('Game', 'AccoladeType.GameID', '=', 'Game.GameID')
            ->where('Accolade.PlayerID', '=', $playerId)
            ->groupBy('AccoladeType.Name', 'Icon', 'Game.Name')
            ->orderByRaw('sum(Accolade.TimesReceived) desc')
            ->get();
    }

    public function getPlayerMatches($playerId)
    {
        return Player::query()
            ->selectRaw("Match.MatchID, Match.MatchDate, Game.Name GameName, Match.Map, GameType.GameTypeName, Match.TeamType, GROUP_CONCAT(Stat.StatKey || ': ' || Stat.StatValue, ', ') Stats")
            ->leftJoin('Stat', 'Stat.PlayerID', '=', 'Player.PlayerID')
            ->leftJoin('Match', 'Stat.MatchID', '=', 'Match.MatchID')
            ->leftJoin('Game', 'Match.GameID', '=', 'Game.GameID')
            ->leftJoin('GameType', 'Match.GameTypeID', '=', 'GameType.GameTypeID')
            ->where('Player.PlayerID', '=', $playerId)
            ->groupBy('Player.PlayerID', 'Match.MatchID')
            ->get();
    }

    public function getPlayerOverview($playerId){
        return Player::query()
            ->selectRaw("Player.Username, Player.Name, COUNT(DISTINCT Match.MatchID) MatchesPlayed, COUNT(DISTINCT Match.MatchDate) GameNights, COUNT(DISTINCT Game.Name) GamesPlayed,
                                    sum(case when Stat.StatKey = 'Place' and Stat.StatValue = 1 then 1 else 0 end) SoloWins,
                                    sum(case when Stat.StatKey = 'Kills' then Stat.StatValue end) Kills,
                                    sum(case when Stat.StatKey = 'Deaths' then Stat.StatValue end) Deaths,
                                    sum(case when Stat.StatKey = 'Assists' then Stat.StatValue end) Assists")
            ->leftJoin('Stat', 'Stat.PlayerID', '=', 'Player.PlayerID')
            ->leftJoin('Match', 'Stat.MatchID', '=', 'Match.MatchID')
            ->leftJoin('Game', 'Match.GameID', '=', 'Game.GameID')
            ->leftJoin('GameType', 'Match.GameTypeID', '=', 'GameType.GameTypeID')
            ->where('Player.PlayerID', '=', $playerId)
            ->groupBy('Player.PlayerID')
            ->firstOrFail();
    }

}
