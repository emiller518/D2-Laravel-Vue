<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stat extends Model
{
    const TABLE = 'Stat';

    const FIELD_MATCH_ID = 'MatchID';
    const FIELD_PLAYER_ID = 'PlayerID';
    const FIELD_STAT_KEY = 'StatKey';
    const FIELD_STAT_VALUE = 'StatValue';

    protected $fillable = [
        self::FIELD_MATCH_ID,
        self::FIELD_PLAYER_ID,
        self::FIELD_STAT_KEY,
        self::FIELD_STAT_VALUE
    ];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
