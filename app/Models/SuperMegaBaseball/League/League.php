<?php

namespace App\Models\SuperMegaBaseball\League;

use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{

    use HasUUID;

    const TABLE = 't_leagues';

    const FIELD_GUID = 'GUID';
    const FIELD_ORIGINAL_GUID = 'originalGUID';
    const FIELD_NAME = 'name';
    const FIELD_ALLOWED_TEAM_TYPE = 'allowedTeamType';

    protected $fillable = [
        self::FIELD_GUID,
        self::FIELD_ORIGINAL_GUID,
        self::FIELD_NAME,
        self::FIELD_ALLOWED_TEAM_TYPE
    ];

    protected $hidden = [self::FIELD_GUID];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GUID;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = self::FIELD_GUID;

    public $timestamps = false;


    function conference(): HasMany {
        return $this->hasMany(Conference::class, 'GUID', self::FIELD_GUID);
    }

}
