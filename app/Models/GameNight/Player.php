<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    const TABLE = 'Player';

    const FIELD_PLAYER_ID = 'PlayerID';
    const FIELD_USERNAME = 'Username';
    const FIELD_NAME = 'Name';

    protected $fillable = [
        self::FIELD_PLAYER_ID,
        self::FIELD_USERNAME,
        self::FIELD_NAME

    ];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_PLAYER_ID;
    public $incrementing = true;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
