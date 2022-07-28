<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    const TABLE = 'Game';

    const FIELD_GAME_ID = 'GameID';
    const FIELD_NAME = 'Name';
    const FIELD_RELEASE_DATE = 'ReleaseDate';
    const FIELD_MAX_PLAYERS = 'MaxPlayers';
    const FIELD_PLAYERS_PER_CONSOLE = 'PlayersPerConsole';
    const FIELD_RELEASE_TYPE = 'ReleaseType';
    const FIELD_GENRE = 'Genre';
    const FIELD_BOX_ART = 'BoxArt';

    protected $fillable = [
        self::FIELD_GAME_ID,
        self::FIELD_NAME,
        self::FIELD_RELEASE_DATE,
        self::FIELD_MAX_PLAYERS,
        self::FIELD_PLAYERS_PER_CONSOLE,
        self::FIELD_RELEASE_TYPE,
        self::FIELD_GENRE,
        self::FIELD_BOX_ART

    ];

    protected $hidden = [self::FIELD_GAME_ID];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GAME_ID;
    public $incrementing = true;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
