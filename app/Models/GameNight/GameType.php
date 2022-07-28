<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameType extends Model
{
    const TABLE = 'GameType';

    const FIELD_GAME_TYPE_ID = 'GameTypeID';
    const FIELD_GAME_ID = 'GameID';
    const FIELD_GAME_TYPE_NAME = 'GameTypeName';
    const FIELD_STAT_COLUMNS = 'StatColumns';

    protected $fillable = [
        self::FIELD_GAME_TYPE_ID,
        self::FIELD_GAME_ID,
        self::FIELD_GAME_TYPE_NAME,
        self::FIELD_STAT_COLUMNS
    ];

    protected $hidden = [self::FIELD_GAME_TYPE_ID];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GAME_TYPE_ID;
    public $incrementing = true;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
