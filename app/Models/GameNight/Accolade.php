<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accolade extends Model
{
    const TABLE = 'Accolade';

    const FIELD_MATCH_ID = 'MatchID';
    const FIELD_PLAYER_ID = 'PlayerID';
    const FIELD_ACCOLADE_TYPE_ID = 'AccoladeTypeID';
    const FIELD_TIMES_RECEIVED = 'TimesReceived';

    protected $fillable = [
        self::FIELD_MATCH_ID,
        self::FIELD_PLAYER_ID,
        self::FIELD_ACCOLADE_TYPE_ID,
        self::FIELD_TIMES_RECEIVED
    ];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
