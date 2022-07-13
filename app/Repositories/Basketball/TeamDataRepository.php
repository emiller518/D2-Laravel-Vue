<?php

namespace App\Repositories;

use App\Models\Basketball\Team;
use DB;

class TeamDataRepository
{
    public function getTeamYearlyOverview(string $abbreviation)
    {
        $teamID = Team::query()
            ->select('Team.TeamID')
            ->where('Abbreviation', '=', $abbreviation)
            ->get()[0]['TeamID'];

        return DB::select("SELECT * FROM (
                            SELECT
                            Season.Name SeasonName, Season.SeasonID,
                            SUM(CASE WHEN Game.WinID = 1 then 1 else 0 end) Wins,
                            SUM(CASE WHEN Game.LossID = 1 then 1 else 0 end) Losses,
                            SUM(Case When Game.WinID = 1 and Game.NonLeague = 0 then 1 else 0 end) ConfWins,
                            SUM(Case WHEN Game.LossID = 1 and Game.NonLeague = 0 then 1 else 0 end) ConfLoss
                            From Game
                            INNER JOIN Season ON Game.SeasonID = Season.SeasonID
                            WHERE (Game.HomeID =" . $teamID . " or Game.AwayID = " . $teamID . ")
                            GROUP BY Season.Name, Season.SeasonID
                            Order by Season.SeasonID desc ) base

                            LEFT JOIN (
                            SELECT * FROM (
                            SELECT
                            a.SeasonName, a.HighPtsName, a.PPG, a.HighPtsPlayerID,
                            ROW_NUMBER() OVER (PARTITION BY a.SeasonName ORDER BY a.PPG desc) as rownum
                             FROM (
                            SELECT
                            Season.Name SeasonName,
                            Player.Name HighPtsName,
                            Player.PlayerID HighPtsPlayerID,
                             ROUND(AVG(PlayerStats.Points),1) as PPG
                            From PlayerStats
                            LEFT JOIN Game on PlayerStats.GameID = Game.GameID
                            LEFT JOIN PlayerYear on PlayerYear.PlayerID = PlayerStats.PlayerID
                            LEFT JOIN Player on PlayerStats.PlayerID = Player.PlayerID
                            LEFT JOIN Season on Game.SeasonID = Season.SeasonID
                            WHERE PlayerYear.SeasonID = Game.SeasonID
                            and (Game.HomeID =" . $teamID . " or Game.AwayID =" . $teamID . ")
                            AND PlayerYear.TeamID =" . $teamID . "
                            Group By Season.Name, Player.Name, Player.PlayerID
                            ORDER BY Season.Name, AVG(PlayerStats.Points) DESC) a
                            ) b
                            where b.rownum = 1 ) ppg
                            on base.SeasonName = ppg.SeasonName

                            LEFT JOIN (
                            SELECT * FROM (
                            SELECT
                            a.SeasonName, a.HighRebName, a.RPG, a.HighRebPlayerID,
                            ROW_NUMBER() OVER (PARTITION BY a.SeasonName ORDER BY a.RPG desc) as rownum
                             FROM (
                            SELECT
                            Season.Name SeasonName,
                            Player.Name HighRebName,
                            Player.PlayerID HighRebPlayerID,
                            ROUND(AVG(PlayerStats.Rebounds),1) as RPG
                            From PlayerStats
                            LEFT JOIN Game on PlayerStats.GameID = Game.GameID
                            LEFT JOIN PlayerYear on PlayerYear.PlayerID = PlayerStats.PlayerID
                            LEFT JOIN Player on PlayerStats.PlayerID = Player.PlayerID
                            LEFT JOIN Season on Game.SeasonID = Season.SeasonID
                            WHERE PlayerYear.SeasonID = Game.SeasonID
                            and (Game.HomeID =" . $teamID . " or Game.AwayID =" . $teamID . ")
                            AND PlayerYear.TeamID =" . $teamID . "
                            Group By Season.Name, Player.Name, Player.PlayerID
                            ORDER BY Season.Name, AVG(PlayerStats.Points) DESC) a
                            ) b
                            where b.rownum = 1 ) rpg
                            ON base.SeasonName = rpg.SeasonName

                            LEFT JOIN (
                            SELECT * FROM (
                            SELECT
                            a.SeasonName, a.HighAstName, a.APG, a.HighAstPlayerID,
                            ROW_NUMBER() OVER (PARTITION BY a.SeasonName ORDER BY a.APG desc) as rownum
                             FROM (
                            SELECT
                            Season.Name SeasonName,
                            Player.Name HighAstName,
                            Player.PlayerID HighAstPlayerID,
                            ROUND(AVG(PlayerStats.Assists),1) as APG
                            From PlayerStats
                            LEFT JOIN Game on PlayerStats.GameID = Game.GameID
                            LEFT JOIN PlayerYear on PlayerYear.PlayerID = PlayerStats.PlayerID
                            LEFT JOIN Player on PlayerStats.PlayerID = Player.PlayerID
                            LEFT JOIN Season on Game.SeasonID = Season.SeasonID
                            WHERE PlayerYear.SeasonID = Game.SeasonID
                            and (Game.HomeID =" . $teamID . " or Game.AwayID =" . $teamID . ")
                            AND PlayerYear.TeamID =" . $teamID . "
                            Group By Season.Name, Player.Name, Player.PlayerID
                            ORDER BY Season.Name, AVG(PlayerStats.Points) DESC) a
                            ) b
                            where b.rownum = 1 ) apg
                            ON base.SeasonName = apg.SeasonName");
    }
}
