<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchInstance extends Model
{
    const TABLE = 'Match';

    const FIELD_MATCH_ID = 'MatchID';
    const FIELD_MATCH_DATE = 'MatchDate';
    const FIELD_GAME_ID = 'GameID';
    const FIELD_MAP = 'Map';
    const FIELD_GAME_TYPE_ID = 'GameTypeID';
    const FIELD_TEAM_TYPE = 'TeamType';
    const FIELD_WINNER = 'Winner';
    const FIELD_TOTAL_PLAYERS = 'TotalPlayers';
    const FIELD_TOTAL_TEAMS = 'TotalTeams';

    protected $fillable = [
        self::FIELD_MATCH_ID,
        self::FIELD_MATCH_DATE,
        self::FIELD_GAME_ID,
        self::FIELD_MAP,
        self::FIELD_GAME_TYPE_ID,
        self::FIELD_TEAM_TYPE,
        self::FIELD_WINNER,
        self::FIELD_TOTAL_PLAYERS,
        self::FIELD_TOTAL_TEAMS

    ];

    protected $hidden = [self::FIELD_MATCH_ID];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_MATCH_ID;
    public $incrementing = true;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
