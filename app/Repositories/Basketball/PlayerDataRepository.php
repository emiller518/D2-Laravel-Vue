<?php

namespace App\Repositories\Basketball;

use App\Models\Basketball\Player;
use App\Models\Basketball\PlayerStats;
use DB;

class PlayerDataRepository
{
    public function getPlayerGameLog(int $playerId)
    {
        return PlayerStats::Query()
            ->select('PlayerYear.PlayerID', 'Season.Name as SeasonName', 'Game.GameDate', 'Game.GameID',
                'PlayerStats.Minutes as MIN', 'PlayerStats.Points as PTS', 'PlayerStats.Rebounds as REB',
                'PlayerStats.Assists as AST', 'PlayerStats.Blocks as BLK', 'PlayerStats.Steals as STL',
                'PlayerStats.FGMade as FGM', 'PlayerStats.FGAttempts as FGA', 'PlayerStats.TPMade AS TPM',
                'PlayerStats.TPAttempts AS TPA', 'PlayerStats.FTMade AS FTM', 'PlayerStats.FTAttempts AS FTA',

                DB::RAW("CASE WHEN PlayerYear.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@' ELSE '' END as loc"),
                DB::RAW("CASE WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.HomeID THEN Away.Name
                WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.AwayID THEN Home.Name
                ELSE '???' END as Opponent"),

                DB::RAW("CASE WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.HomeID THEN Away.Abbreviation
                WHEN PlayerYear.SeasonID = Season.SeasonID AND PlayerYear.TeamID = Game.AwayID THEN Home.Abbreviation
                ELSE '???' END as OpponentAbbr"),

                DB::RAW("CASE WHEN PlayerYear.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                WHEN PlayerYear.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                WHEN PlayerYear.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                WHEN PlayerYear.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                ELSE '' END as Result"),

                DB::RAW("CASE WHEN PlayerStats.Starter = 1 then '*' ELSE '' END as GS"),

                DB::RAW("IFNULL(ROUND((PlayerStats.FGMade / PlayerStats.FGAttempts) * 100,1),0) AS FGPCT"),
                DB::RAW("IFNULL(ROUND((PlayerStats.`TPMade` / PlayerStats.`TPAttempts`) * 100,1),0) AS TPPCT"),
                DB::RAW("IFNULL(ROUND((PlayerStats.`FTMade` / PlayerStats.`FTAttempts`) * 100,0),0) AS FTPCT"))

            ->leftJoin("Game", "PlayerStats.GameID", "=", "Game.GameID")
            ->leftJoin("Season", "Game.SeasonID", "=", "Season.SeasonID")
            ->leftJoin("Player", "PlayerStats.PlayerID", "=", "Player.PlayerID")
            ->leftJoin("PlayerYear", "PlayerYear.SeasonID", "=", "Game.SeasonID")
            ->leftJoin("Class", "PlayerYear.ClassID", "=", "Class.ClassID")
            ->leftJoin("Team", "PlayerYear.TeamID", "=", "Team.TeamID")
            ->leftJoin("Team as Home", "Game.HomeID", "=", "Home.TeamID")
            ->leftJoin("Team as Away", "Game.AwayID", "=", "Away.TeamID")
            ->where("PlayerYear.PlayerID", "=", intval($playerId))
            ->where("Player.PlayerID", "=", intval($playerId))
            ->orderBy('Game.GameDate', 'asc')
            ->get();
    }


    public function getPlayerSeasonStats(int $playerId) {
        return PlayerStats::query()
            ->select('PlayerYear.PlayerID', 'Class.Abbreviation as Year', 'Team.Name as Team', 'Team.TeamID',
                'Team.Abbreviation', 'PlayerYear.Position', 'Season.Name as Season',

                DB::RAW("CASE WHEN Season.SeasonID < 10
							then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg')
							else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg')  end as image"),

                DB::RAW("COUNT(DISTINCT PlayerStats.GameID) as GP"),
                DB::RAW("SUM(PlayerStats.Starter) as GS"),
                DB::RAW("ROUND(AVG(PlayerStats.Minutes),1) AS MIN"),
                DB::RAW("ROUND(AVG(PlayerStats.Points),1) AS PTS"),
                DB::RAW("ROUND(AVG(PlayerStats.Rebounds),1) AS REB"),
                DB::RAW("ROUND(AVG(PlayerStats.Assists),1) AS AST"),
                DB::RAW("ROUND(AVG(PlayerStats.Blocks),1) AS BLK"),
                DB::RAW("ROUND(AVG(PlayerStats.Steals),1) AS STL"),
                DB::RAW("ROUND(AVG(PlayerStats.`FGMade`),1) AS FGM"),
                DB::RAW("ROUND(AVG(PlayerStats.`FGAttempts`),1) AS FGA"),
                DB::RAW("ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1) AS FGPCT"),
                DB::RAW("ROUND(AVG(PlayerStats.`TPMade`),1) AS TPM"),
                DB::RAW("ROUND(AVG(PlayerStats.`TPAttempts`),1) AS TPA"),
                DB::RAW("ROUND(((AVG(PlayerStats.`TPMade`) / AVG(PlayerStats.`TPAttempts`)) * 100),1) AS TPPCT"),
                DB::RAW("ROUND(AVG(PlayerStats.`FTMade`),1) AS FTM"),
                DB::RAW("ROUND(AVG(PlayerStats.`FTAttempts`),1) AS FTA"),
                DB::RAW("ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0) AS FTPCT"))
            ->leftJoin("Game", "PlayerStats.GameID", "=", "Game.GameID")
            ->leftJoin("Season", "Game.SeasonID", "=", "Season.SeasonID")
            ->leftJoin("Player", "PlayerStats.PlayerID", "=", "Player.PlayerID")
            ->leftJoin("PlayerYear", "PlayerYear.SeasonID", "=", "Game.SeasonID")
            ->leftJoin("Class", "PlayerYear.ClassID", "=", "Class.ClassID")
            ->leftJoin("Team", "PlayerYear.TeamID", "=", "Team.TeamID")
            ->where("PlayerYear.PlayerID", "=", intval($playerId))
            ->where("Player.PlayerID", "=", intval($playerId))
            ->groupBy('PlayerYear.PlayerID', 'Class.Abbreviation', 'Team.Name', 'Team.TeamID',
                'Team.Abbreviation', 'PlayerYear.Position', 'Season.Name',

                DB::RAW("CASE WHEN Season.SeasonID < 10
                    then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg')
                    else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg')  end"))
            ->orderBy('Season.Name', 'asc')
            ->get();
    }

    public function getPlayerSeasonStatsPer30(int $playerId)
    {
        return PlayerStats::query()
            ->select('PlayerYear.PlayerID', 'Class.Abbreviation as Year', 'Team.Name as Team', 'Team.TeamID',
                'Team.Abbreviation', 'PlayerYear.Position', 'Season.Name as Season',

                DB::RAW("CASE WHEN Season.SeasonID < 10
							then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg')
							else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg')  end as image"),

                DB::RAW("COUNT(DISTINCT PlayerStats.GameID) as GP"),
                DB::RAW("SUM(PlayerStats.Starter) as GS"),
                DB::RAW("ROUND(AVG(PlayerStats.Minutes),1) AS MIN"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Points),1) AS PTS"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Rebounds),1) AS REB"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Assists),1) AS AST"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Blocks),1) AS BLK"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.Steals),1) AS STL"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FGMade),1) AS FGM"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FGAttempts),1) AS FGA"),
                DB::RAW("ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1) AS FGPCT"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.`TPMade`),1) AS TPM"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.`TPAttempts`),1) AS TPA"),
                DB::RAW("ROUND(((AVG(PlayerStats.`TPMade`) / AVG(PlayerStats.`TPAttempts`)) * 100),1) AS TPPCT"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FTMade),1) AS FTM"),
                DB::RAW("ROUND(30/AVG(PlayerStats.Minutes) * AVG(PlayerStats.FTAttempts),1) AS FTA"),
                DB::RAW("ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0) AS FTPCT"))
            ->leftJoin("Game", "PlayerStats.GameID", "=", "Game.GameID")
            ->leftJoin("Season", "Game.SeasonID", "=", "Season.SeasonID")
            ->leftJoin("Player", "PlayerStats.PlayerID", "=", "Player.PlayerID")
            ->leftJoin("PlayerYear", "PlayerYear.SeasonID", "=", "Game.SeasonID")
            ->leftJoin("Class", "PlayerYear.ClassID", "=", "Class.ClassID")
            ->leftJoin("Team", "PlayerYear.TeamID", "=", "Team.TeamID")
            ->where("PlayerYear.PlayerID", "=", intval($playerId))
            ->where("Player.PlayerID", "=", intval($playerId))
            ->groupBy('PlayerYear.PlayerID', 'Class.Abbreviation', 'Team.Name', 'Team.TeamID',
                'Team.Abbreviation', 'PlayerYear.Position', 'Season.Name',

                DB::RAW("CASE WHEN Season.SeasonID < 10
                    then concat(Team.Abbreviation, 0, Season.SeasonID, PlayerYear.PlayerID, '.jpg')
                    else concat(Team.Abbreviation, Season.SeasonID, PlayerYear.PlayerID, '.jpg')  end"))
            ->orderBy('Season.Name', 'asc')
            ->get();
    }

    public function getPlayerProfile(int $playerId)
    {
        return Player::query()
            ->select('Player.PlayerID', 'Player.Name', 'Player.City', 'Player.State', 'Player.PreviousSchool',
                'PlayerYear.Height', 'PlayerYear.Position', 'PlayerYear.Number', 'Team.Name as TeamName', 'Team.Abbreviation',
                DB::RAW('CONCAT(Team.Abbreviation, PlayerYear.SeasonID, Player.PlayerID, ".jpg") img'))
            ->leftJoin('PlayerYear', 'PlayerYear.PlayerID', '=', 'Player.PlayerID')
            ->leftJoin('Team', 'PlayerYear.TeamID', '=', 'Team.TeamID')
            ->where('Player.PlayerID', '=', $playerId)
            ->where('PlayerYear.SeasonID', '=',
                DB::RAW("(SELECT MAX(SeasonID) From PlayerYear Where PlayerID = " . $playerId . ")"))
            ->get();
    }
}
