<?php

namespace App\Repositories\SuperMegaBaseball;

use App\Models\SuperMegaBaseball\Pivot\PlayerLocalID;
use App\Models\SuperMegaBaseball\Player\Player;
use App\Models\SuperMegaBaseball\Player\PlayerOption;
use Illuminate\Support\Facades\DB;

class PlayerRepository
{
    public function getAllPlayers()
    {
        return Player::query()
            ->selectRaw('hex(t_baseball_players.GUID), hex(teamguid) ')
            ->leftJoin('t_baseball_player_local_ids', 't_baseball_players.GUID', '=', 't_baseball_player_local_ids.GUID')
            ->whereRaw( "hex(teamGUID) = (SELECT hex(GUID) From t_teams where teamname = 'Rangers')")
            ->get();
    }

    public function getPlayerData($team = 'Rangers')
    {
        return PlayerOption::query()
            ->selectRaw("baseballplayerlocalid playerId,

                                    max(case when optionkey = 54 and optionvalue = 1 and t_pitching_rotations.pitchingRotation IS NOT NULL then t_pitching_rotations.pitchingRotation + 1
                                    when optionkey = 54 and optionvalue = 1 and t_pitching_rotations.pitchingRotation IS NULL then 'Bullpen'
                                    when optionkey = 54 and optionvalue != 1 and t_batting_orders.battingOrder IS NOT NULL then t_batting_orders.battingOrder
                                    when optionkey = 54 and optionvalue != 1 and t_batting_orders.battingOrder IS NULL then 'Bench'
                                    end) lineup,

                                    max(case when optionkey = 66 then optionvalue end) first,
                                    max(case when optionkey = 67 then optionvalue end) last,
                                    t_baseball_players.age,
                                    t_baseball_players.power,
                                    t_baseball_players.contact,
                                    t_baseball_players.speed,
                                    t_baseball_players.fielding,
                                    t_baseball_players.arm,
                                    t_baseball_players.velocity,
                                    t_baseball_players.junk,
                                    t_baseball_players.accuracy,
                                    max(case when optionkey = 0 then optionvalue end) gender,
                                    max(case when optionkey = 4 then optionvalue end) throws,
                                    max(case when optionkey = 5 then optionvalue end) bats,
                                    max(case when optionkey = 8 then optionvalue end) personality,
                                    max(case when optionkey = 12 then optionvalue end) head,
                                    max(case when optionkey = 14 then optionvalue end) eyebrows,
                                    max(case when optionkey = 15 then optionvalue end) hair,
                                    max(case when optionkey = 0 then optionvalue end) gender,
                                    max(case when optionkey = 4 then optionvalue end) throws,
                                    max(case when optionkey = 5 then optionvalue end) bats,
                                    max(case when optionkey = 8 then optionvalue end) personality,
                                    max(case when optionkey = 12 then optionvalue end) head,
                                    max(case when optionkey = 14 then optionvalue end) eyebrows,
                                    max(case when optionkey = 15 then optionvalue end) hair,
                                    max(case when optionkey = 16 then optionvalue end) facialHair,
                                    max(case when optionkey = 17 then optionvalue end) eyeBlack,
                                    max(case when optionkey = 18 then optionvalue end) helmetTar,
                                    max(case when optionkey = 19 then optionvalue end) eyeWear,
                                    max(case when optionkey = 20 then optionvalue - 1 end) number,
                                    max(case when optionkey = 22 then optionvalue end) physique,
                                    max(case when optionkey = 25 then optionvalue end) elbowGuard,
                                    max(case when optionkey = 26 then optionvalue end) ankleGuard,
                                    max(case when optionkey = 27 then optionvalue end) undershirt,
                                    max(case when optionkey = 28 then optionvalue end) leftTattoo,
                                    max(case when optionkey = 29 then optionvalue end) rightTattoo,
                                    max(case when optionkey = 30 then optionvalue end) leftSleeve,
                                    max(case when optionkey = 31 then optionvalue end) rightSleeve,
                                    max(case when optionkey = 32 then optionvalue end) pants,
                                    max(case when optionkey = 36 then optionvalue end) wristband,
                                    max(case when optionkey = 39 then optionvalue end) battingGlove,
                                    max(case when optionkey = 40 then optionvalue end) cleats,
                                    max(case when optionkey = 41 then optionvalue end) wristTape,
                                    max(case when optionkey = 48 then optionvalue end) windup,
                                    max(case when optionkey = 49 then optionvalue end) armAngle,
                                    max(case when optionkey = 50 then optionvalue end) battingRoutine,
                                    max(case when optionkey = 51 then optionvalue end) battingStance,
                                    max(case when optionkey = 52 then optionvalue end) walkUpSong,
                                    max(case when optionkey = 53 then optionvalue end) portrait,
                                    max(case when optionkey = 54 then optionvalue end) primaryPosition,
                                    max(case when optionkey = 55 and optionvalue IS NOT NULL then optionvalue when optionkey = 57 then optionvalue else 0 end) secondaryPosition,
                                    max(case when optionkey = 54 and optionvalue = 1 then 'P' else 'F' end) positionType,
                                    max(case when optionkey = 59 then optionvalue end) pFourSeam,
                                    max(case when optionkey = 60 then optionvalue end) pTwoSeam,
                                    max(case when optionkey = 61 then optionvalue end) pScrewBall,
                                    max(case when optionkey = 62 then optionvalue end) pChangeUp,
                                    max(case when optionkey = 63 then optionvalue end) pForkBall,
                                    max(case when optionkey = 64 then optionvalue end) pCurveBall,
                                    max(case when optionkey = 65 then optionvalue end) pCutFastBall,
                                    max(case when optionkey = 92 then optionvalue end) batStyle,
                                    max(case when optionkey = 93 then optionvalue end) batGrip,
                                    max(case when optionkey = 104 then optionvalue end) helmetStyle")
            ->leftJoin('t_baseball_player_local_ids', 't_baseball_player_options.baseballplayerlocalid', '=', 't_baseball_player_local_ids.localID')
            ->leftJoin('t_baseball_players', 't_baseball_player_local_ids.GUID', '=', 't_baseball_players.GUID')
            ->leftJoin('t_teams', 't_teams.GUID', '=', 't_baseball_players.teamGUID')
            ->leftJoin('t_batting_orders', 't_baseball_players.GUID', '=', 't_batting_orders.baseballPlayerGUID')
            ->leftJoin('t_pitching_rotations', 't_pitching_rotations.pitcherGUID', '=', 't_baseball_players.GUID')
            ->where( 't_teams.teamName', '=', $team)
            ->whereRaw('(t_batting_orders.startingLineupID in (SELECT max(startingLineupID) FROM t_starting_lineups group by lineupGUID) or (t_batting_orders.startingLineupID is null or t_batting_orders.battingOrder = 9))')
            ->groupBy('baseballplayerlocalid')
            ->orderByRaw('max(case when optionkey = 54 and optionvalue != 1 and t_batting_orders.battingOrder IS NOT NULL then t_batting_orders.battingOrder
                                when optionkey = 54 and optionvalue != 1 and t_batting_orders.battingOrder IS NULL then 10
                                when optionkey = 54 and optionvalue = 1 and t_pitching_rotations.pitchingRotation IS NOT NULL then t_pitching_rotations.pitchingRotation + 11
                                when optionkey = 57 and optionvalue IS NOT NULL and t_pitching_rotations.pitchingRotation IS NULL then optionvalue + 14 end)')
            ->get();
    }

    public function updateVisuals($playerId, $optionKey, $optionValue)
    {
        PlayerOption::query()
            ->where(PlayerOption::FIELD_LOCAL_ID, '=', $playerId)
            ->where(PlayerOption::FIELD_OPTION_KEY, '=', $optionKey)
            ->update([PlayerOption::FIELD_OPTION_VALUE => $optionValue]);
    }

    // NEED FEEDBACK: SQL Injection Possibilities for this?
    public function updateStats($playerId, $optionKey, $optionValue){
        Player::query()
            ->whereNotNull($optionKey)
            ->whereIn(Player::FIELD_GUID,
                        [DB::RAW("(select " . Player::FIELD_GUID . " from " . PlayerLocalID::TABLE . " where localID = " . $playerId . ")")])
            ->update([$optionKey => $optionValue]);
    }

}
