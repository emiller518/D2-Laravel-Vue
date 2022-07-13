<?php

namespace App\Repositories\SuperMegaBaseball;

use App\Models\SuperMegaBaseball\Player;
use App\Models\SuperMegaBaseball\PlayerAttributes;
use DB;

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

    public function getPlayerData()
    {
        return PlayerAttributes::query()
            ->selectRaw('baseballplayerlocalid ID,
                                    max(case when optionkey = 66 then optionvalue end) First,
                                    max(case when optionkey = 67 then optionvalue end) Last,
                                    t_baseball_players.age Age,
                                    t_baseball_players.power Power,
                                    t_baseball_players.contact Contact,
                                    t_baseball_players.speed Speed,
                                    t_baseball_players.fielding Fielding,
                                    t_baseball_players.arm Arm,
                                    t_baseball_players.velocity Velocity,
                                    t_baseball_players.junk Junk,
                                    t_baseball_players.accuracy Accuracy')
            ->leftJoin('t_baseball_player_local_ids', 't_baseball_player_options.baseballplayerlocalid', '=', 't_baseball_player_local_ids.localID')
            ->leftJoin('t_baseball_players', 't_baseball_player_local_ids.GUID', '=', 't_baseball_players.GUID')
            ->leftJoin('t_teams', 't_teams.GUID', '=', 't_baseball_players.teamGUID')
            ->where( 't_teams.teamName', '=', 'Rangers')
            ->groupBy('baseballplayerlocalid')
            ->orderByRaw('max(case when optionkey = 67 then optionvalue end)')
            ->get();
    }

}

//
//max(case when optionkey = 0 then optionvalue end) gender,
//max(case when optionkey = 4 then optionvalue end) throws,
//max(case when optionkey = 5 then optionvalue end) bats,
//max(case when optionkey = 8 then optionvalue end) personality,
//max(case when optionkey = 12 then optionvalue end) head,
//max(case when optionkey = 14 then optionvalue end) eyebrows,
//max(case when optionkey = 15 then optionvalue end) hair,
//max(case when optionkey = 16 then optionvalue end) facialhair,
//max(case when optionkey = 17 then optionvalue end) eyeblack,
//max(case when optionkey = 18 then optionvalue end) UNK_helmettar,
//max(case when optionkey = 19 then optionvalue end) UNK_eyewear,
//max(case when optionkey = 20 then optionvalue end) number,
//max(case when optionkey = 22 then optionvalue end) physique,
//max(case when optionkey = 25 then optionvalue end) elbowguard,
//max(case when optionkey = 26 then optionvalue end) ankleguard,
//max(case when optionkey = 27 then optionvalue end) undershirt,
//max(case when optionkey = 28 then optionvalue end) lefttattoo,
//max(case when optionkey = 29 then optionvalue end) righttattoo,
//max(case when optionkey = 30 then optionvalue end) leftsleeve,
//max(case when optionkey = 31 then optionvalue end) rightsleeve,
//max(case when optionkey = 32 then optionvalue end) pants,
//max(case when optionkey = 36 then optionvalue end) wristband,
//max(case when optionkey = 39 then optionvalue end) battingglove,
//max(case when optionkey = 40 then optionvalue end) cleats,
//max(case when optionkey = 41 then optionvalue end) wristtape,
//max(case when optionkey = 48 then optionvalue end) UNK_windup,
//max(case when optionkey = 49 then optionvalue end) UNK_armangle,
//max(case when optionkey = 50 then optionvalue end) battingroutine,
//max(case when optionkey = 51 then optionvalue end) battingstance,
//max(case when optionkey = 52 then optionvalue end) walkupsong,
//max(case when optionkey = 53 then optionvalue end) UNKNOWN,
//max(case when optionkey = 54 then optionvalue end) UNK_primarypos,
//max(case when optionkey = 57 then optionvalue end) option57,
//max(case when optionkey = 58 then optionvalue end) option58,
//max(case when optionkey = 59 then optionvalue end) option59,
//max(case when optionkey = 60 then optionvalue end) option60,
//max(case when optionkey = 61 then optionvalue end) option61,
//max(case when optionkey = 62 then optionvalue end) option62,
//max(case when optionkey = 63 then optionvalue end) option63,
//max(case when optionkey = 64 then optionvalue end) option64,
//max(case when optionkey = 65 then optionvalue end) option65,
//max(case when optionkey = 92 then optionvalue end) batstyle,
//max(case when optionkey = 93 then optionvalue end) batgrip,
//max(case when optionkey = 104 then optionvalue end) helmetstyle



//      -- Update any baseball stat attribute
//UPDATE t_baseball_players
//SET age = 33
//where GUID in (select GUID from t_baseball_player_local_ids where localid = 3129)
//and age IS NOT NULL;
//
//      -- Update any visualization attribute
//UPDATE t_baseball_player_options
//SET optionValue = 0
//WHERE baseballPlayerLocalID = 3129 and optionKey = 1;
//
//      -- Baseball Stat Pseudocode for API
//UPDATE t_baseball_players
//SET [variable] = [changed text value]
//where GUID in (select GUID from t_baseball_player_local_ids where localid = [playerid])
//and [variable] IS NOT NULL; -- this prevents players getting pitcher data or vice versa
//
//      -- Visualization Pseudocode for API
//UPDATE t_baseball_player_options
//SET optionValue = [optionValue]
//WHERE baseballPlayerLocalID = [playerid] and optionKey = [optionKey];


