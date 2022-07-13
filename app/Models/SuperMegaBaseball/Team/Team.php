<?php

namespace App\Models\SuperMegaBaseball\Team;

use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{

    use HasUUID;

    const TABLE = 't_teams';

    const FIELD_GUID = 'GUID';
    const FIELD_ORIGINAL_GUID = 'originalGUID';
    const FIELD_TEAM_NAME = 'teamName';
    const FIELD_IS_BUILT_IN = 'isBuiltIn';
    const FIELD_IS_GENERATED = 'isGenerated';
    const FIELD_TEAM_TYPE = 'teamType';
    const FIELD_TEMPLATE_TEAM_FAMILY = 'templateTeamFamily';
    const FIELD_IS_HISTORICAL = 'isHistorical';

    protected $fillable = [
        self::FIELD_GUID,
        self::FIELD_ORIGINAL_GUID,
        self::FIELD_TEAM_NAME,
        self::FIELD_IS_BUILT_IN,
        self::FIELD_IS_GENERATED,
        self::FIELD_TEAM_TYPE,
        self::FIELD_TEMPLATE_TEAM_FAMILY,
        self::FIELD_IS_HISTORICAL

    ];

    protected $hidden = [self::FIELD_GUID];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GUID;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = self::FIELD_GUID;

    public $timestamps = false;


    function Player(): HasMany {
        return $this->hasMany(Player::class, Player::FIELD_TEAM_GUID, self::FIELD_GUID);
    }

}
