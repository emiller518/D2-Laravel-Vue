<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    const TABLE = 'Team';

    const FIELD_TEAM_ID = 'TeamID';
    const FIELD_PLAYER_ID = 'PlayerID';

    protected $fillable = [
        self::FIELD_TEAM_ID,
        self::FIELD_PLAYER_ID
    ];

    protected $hidden = [self::FIELD_TEAM_ID];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_TEAM_ID;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
