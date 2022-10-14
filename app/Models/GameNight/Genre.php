<?php

namespace App\Models\GameNight;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccoladeType extends Model
{
    const TABLE = 'AccoladeType';

    const FIELD_ACCOLADE_TYPE_ID = 'AccoladeTypeID';
    const FIELD_GAME_ID = 'GameID';
    const FIELD_NAME = 'Name';
    const FIELD_ICON = 'Icon';

    protected $fillable = [
        self::FIELD_ACCOLADE_TYPE_ID,
        self::FIELD_GAME_ID,
        self::FIELD_NAME,
        self::FIELD_ICON
    ];

    protected $connection = 'gamenight_sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_ACCOLADE_TYPE_ID;
    public $incrementing = true;

    public $timestamps = false;

//
//    function Player(): HasMany {
//        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
//    }

}
