<?php

namespace App\Http\Controllers;

use App\Models\Basketball\Player;
use App\Models\Basketball\PlayerStats;
use App\Models\Basketball\Season;
use App\Repositories\TeamDataRepository;
use DB;

class TeamController extends Controller {


    /**
     * @var TeamDataRepository
     */
    private $teamDataRepository;

    /**
     * @param TeamDataRepository $teamDataRepository
     */
    public function __construct(TeamDataRepository $teamDataRepository)
    {
        $this->teamDataRepository = $teamDataRepository;
    }

    public function teamOverview(string $abbreviation){
        $teamData = [];
        $teamData['overview'] = $this->teamDataRepository->getTeamYearlyOverview($abbreviation);
        return $teamData;
    }



    // Retrieve function
    public function year($abbr, $year) {

        $SeasonID = Season::query()
            ->select('SeasonID')
            ->where('Name', '=', $year)
            ->first()
            ->SeasonID;

        $GameLog = PlayerStats::query()
            ->select('Game.GameID', 'Game.GameDate', 'Season.Name as SeasonName',
                            DB::RAW("CASE WHEN Game.Exhibition = 1 then '(E) '
                                    WHEN Game.Neutral = 1 then '(N) '
                                    WHEN Team.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@ '
                                    ELSE '' END as loc"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.HomeID THEN Away.Name
                                    WHEN Team.TeamID = Game.AwayID THEN Home.Name
                                    ELSE '???' END as Opponent"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.HomeID THEN Away.Abbreviation
                                    WHEN Team.TeamID = Game.AwayID THEN Home.Abbreviation
                                    ELSE '???' END as OpponentAbbr"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                                    WHEN Team.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                                    WHEN Team.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                                    WHEN Team.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                                    ELSE '' END as Result"),
                            DB::RAW("SUM(PlayerStats.Minutes) as MIN"),
                            DB::RAW("SUM(PlayerStats.Points) as PTS"),
                            DB::RAW("SUM(PlayerStats.Rebounds) as REB"),
                            DB::RAW("SUM(PlayerStats.Assists) as AST"),
                            DB::RAW("SUM(PlayerStats.Blocks) as BLK"),
                            DB::RAW("SUM(PlayerStats.Steals) as STL"),
                            DB::RAW("SUM(PlayerStats.Turnovers) as TRN"),
                            DB::RAW("SUM(PlayerStats.FGMade) as FGM"),
                            DB::RAW("SUM(PlayerStats.FGAttempts) as FGA"),
                            DB::RAW("IFNULL(ROUND((SUM(PlayerStats.FGMade) / SUM(PlayerStats.FGAttempts)) * 100,0),0) AS FGPCT"),
                            DB::RAW("SUM(PlayerStats.TPMade) as TPM"),
                            DB::RAW("SUM(PlayerStats.TPAttempts) as TPA"),
                            DB::RAW("IFNULL(ROUND((SUM(PlayerStats.TPMade) / SUM(PlayerStats.TPAttempts)) * 100,0),0) AS TPPCT"),
                            DB::RAW("SUM(PlayerStats.FTMade) AS FTM"),
                            DB::RAW("SUM(PlayerStats.FTAttempts) AS FTA"),
                            DB::RAW("IFNULL(ROUND((SUM(PlayerStats.FTMade) / SUM(PlayerStats.FTAttempts)) * 100,0),0) AS FTPCT"))
            ->leftJoin("Game", "PlayerStats.GameID", "=", "Game.GameID")
            ->leftJoin("Season", "Game.SeasonID", "=", "Season.SeasonID")
            ->leftJoin("Player", "PlayerStats.PlayerID", "=", "Player.PlayerID")
            ->leftJoin("PlayerYear", "Player.PlayerID", "=", "PlayerYear.PlayerID")
            ->leftJoin("Class", "PlayerYear.ClassID", "=", "Class.ClassID")
            ->leftJoin("Team", "PlayerYear.TeamID", "=", "Team.TeamID")
            ->leftJoin("Team as Home", "Game.HomeID", "=", "Home.TeamID")
            ->leftJoin("Team as Away", "Game.AwayID", "=", "Away.TeamID")
            ->where('Team.Abbreviation', '=', $abbr)
            ->where('Season.SeasonID', '=',  intval($SeasonID))
            ->where('PlayerYear.SeasonID', '=', intval($SeasonID))
            ->groupBy('Game.GameID', 'Game.GameDate', 'Season.Name',
                            DB::RAW("CASE WHEN Game.Exhibition = 1 then '(E) '
                                                WHEN Game.Neutral = 1 then '(N) '
                                                WHEN Team.TeamID = Game.AwayID and Game.Neutral = 0 THEN '@ '
                                                ELSE '' END"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.HomeID THEN Away.Name
                                                WHEN Team.TeamID = Game.AwayID THEN Home.Name
                                                ELSE '???' END"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.HomeID THEN Away.Abbreviation
                                                WHEN Team.TeamID = Game.AwayID THEN Home.Abbreviation
                                                ELSE '???' END"),
                            DB::RAW("CASE WHEN Team.TeamID = Game.AwayID and Game.AwayPts > Game.HomePts THEN CONCAT('W, ', Game.AwayPts, '-', Game.HomePts)
                                                WHEN Team.TeamID = Game.AwayID and Game.AwayPts < Game.HomePts THEN CONCAT('L, ', Game.HomePts, '-', Game.AwayPts)
                                                WHEN Team.TeamID = Game.HomeID and Game.HomePts > Game.AwayPts THEN CONCAT('W, ', Game.HomePts, '-', Game.AwayPts)
                                                WHEN Team.TeamID = Game.HomeID and Game.HomePts < Game.AwayPts THEN CONCAT('L, ', Game.AwayPts, '-', Game.HomePts)
                                                ELSE '' END"))
            ->orderBy('Game.GameDate')
            ->get();


        $TeamRoster = Player::Query()
            ->select('Player.PlayerID', 'PlayerYear.Number as PlayerNum', 'Player.Name as PlayerName', 'PlayerYear.Height', 'PlayerYear.Position', 'Class.Abbreviation as Class',
                     'Player.PreviousSchool as PrevSchool', DB::RAW("CONCAT(Player.City, ', ', Player.State) as Hometown"))
            ->leftJoin("PlayerYear","Player.PlayerID", "=","PlayerYear.PlayerID")
            ->leftJoin("Season","PlayerYear.SeasonID", "=","Season.SeasonID")
            ->leftJoin("Class","PlayerYear.ClassID", "=","Class.ClassID")
            ->leftJoin("Team","PlayerYear.TeamID", "=","Team.TeamID")
            ->where('Team.Abbreviation', '=', $abbr)
            ->where('Season.SeasonID', '=',  intval($SeasonID))
            ->where('Player.Name', '!=', 'Team')
            ->orderBy('PlayerYear.Number', 'asc')
            ->get();


        $PlayerStatistics = PlayerStats::query()
            ->select('PlayerYear.PlayerID', 'Player.Name as PlayerName', 'Season.Name as SeasonName', 'Class.Abbreviation as Class',
                                'Team.Abbreviation as Team', 'PlayerYear.Position', 'PlayerYear.Number',
                DB::RAW("COUNT(DISTINCT PlayerStats.GameID) as GP"),
                DB::RAW("SUM(PlayerStats.Starter) as GS"),
                DB::RAW("ROUND(AVG(PlayerStats.Minutes),1) AS MIN"),
                DB::RAW("ROUND(AVG(PlayerStats.Points),1) AS PTS"),
                DB::RAW("ROUND(AVG(PlayerStats.Rebounds),1) AS REB"),
                DB::RAW("ROUND(AVG(PlayerStats.Assists),1) AS AST"),
                DB::RAW("ROUND(AVG(PlayerStats.Blocks),1) AS BLK"),
                DB::RAW("ROUND(AVG(PlayerStats.Steals),1) AS STL"),
                DB::RAW("ROUND(AVG(PlayerStats.Turnovers),1) AS TRN"),
                DB::RAW("ROUND(AVG(PlayerStats.`FGMade`),1) AS `FGM`"),
                DB::RAW("ROUND(AVG(PlayerStats.`FGAttempts`),1) AS `FGA`"),
                DB::RAW("IFNULL(ROUND(((AVG(PlayerStats.FGMade) / AVG(PlayerStats.FGAttempts)) * 100),1),0) AS FGPCT"),
                DB::RAW("ROUND(AVG(PlayerStats.`TPMade`),1) AS `TPM`"),
                DB::RAW("ROUND(AVG(PlayerStats.`TPAttempts`),1) AS `TPA`"),
                DB::RAW("IFNULL(ROUND(((AVG(PlayerStats.`TPMade`) / AVG(PlayerStats.`TPAttempts`)) * 100),1),0) AS 3PPCT"),
                DB::RAW("ROUND(AVG(PlayerStats.`FTMade`),1) AS `FTM`"),
                DB::RAW("ROUND(AVG(PlayerStats.`FTAttempts`),1) AS `FTA`"),
                DB::RAW("IFNULL(ROUND(((AVG(PlayerStats.`FTMade`) / AVG(PlayerStats.`FTAttempts`)) * 100),0),0) AS FTPCT"))
            ->leftJoin("Game", "PlayerStats.GameID", "=", "Game.GameID")
            ->leftJoin("Season", "Game.SeasonID", "=", "Season.SeasonID")
            ->leftJoin("Player", "PlayerStats.PlayerID", "=", "Player.PlayerID")
            ->leftJoin("PlayerYear", "Player.PlayerID", "=", "PlayerYear.PlayerID")
            ->leftJoin("Class", "PlayerYear.ClassID", "=", "Class.ClassID")
            ->leftJoin("Team", "PlayerYear.TeamID", "=", "Team.TeamID")
            //and PlayerYear.SeasonID = Game.SeasonID"
            ->where('Team.Abbreviation', '=', $abbr)
            ->where('Season.SeasonID', '=',  intval($SeasonID))
            ->where('Player.Name', '!=', 'Team')
            ->where('PlayerYear.SeasonID', '=', intval($SeasonID))
            ->groupBy('PlayerYear.PlayerID', 'Player.Name', 'Season.Name', 'Class.Abbreviation',
                'Team.Abbreviation', 'PlayerYear.Position', 'PlayerYear.Number')
            ->orderBy(DB::RAW("SUM(PlayerStats.Starter)"), 'desc')
            ->orderBy(DB::RAW("ROUND(AVG(PlayerStats.Minutes),1)"), 'desc')
            ->get();

        return view('teamyear')->with(compact('GameLog', 'TeamRoster', 'PlayerStatistics'));

    }

}
