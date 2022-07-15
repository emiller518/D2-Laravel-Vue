<?php

namespace App\Models\SuperMegaBaseball\Player;

use App\Models\SuperMegaBaseball\Pivot\PlayerLocalID;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Player extends Model
{

    use HasUUID;

    const TABLE = 't_baseball_players';

    const FIELD_GUID = 'GUID';
    const FIELD_ORIGINAL_GUID = 'originalGUID';
    const FIELD_TEAM_GUID = 'teamGUID';
    const FIELD_POWER = 'power';
    const FIELD_CONTACT = 'contact';
    const FIELD_SPEED = 'speed';
    const FIELD_FIELDING = 'fielding';
    const FIELD_ARM = 'arm';
    const FIELD_VELOCITY = 'velocity';
    const FIELD_JUNK = 'junk';
    const FIELD_ACCURACY = 'accuracy';
    const FIELD_AGE = 'age';

    protected $fillable = [
        self::FIELD_GUID,
        self::FIELD_ORIGINAL_GUID,
        self::FIELD_TEAM_GUID,
        self::FIELD_POWER,
        self::FIELD_CONTACT,
        self::FIELD_SPEED,
        self::FIELD_FIELDING,
        self::FIELD_ARM,
        self::FIELD_VELOCITY,
        self::FIELD_JUNK,
        self::FIELD_ACCURACY,
        self::FIELD_AGE

    ];

    protected $hidden = [self::FIELD_GUID];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GUID;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = self::FIELD_GUID;

    public $timestamps = false;


    function PlayerLocalID(): HasOne {
        return $this->hasOne(PlayerLocalID::class, PlayerLocalID::FIELD_GUID, self::FIELD_GUID);
    }

    function Team(): HasOne {
        return $this->hasOne(Team::class, Team::FIELD_GUID, self::FIELD_TEAM_GUID);
    }

}
