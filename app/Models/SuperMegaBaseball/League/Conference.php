<?php

namespace App\Models\SuperMegaBaseball\League;

use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conference extends Model
{

    use HasUUID;

    const TABLE = 't_conferences';

    const FIELD_GUID = 'GUID';
    const FIELD_LEAGUE_GUID = 'leagueGUID';
    const FIELD_NAME = 'name';
    const FIELD_USES_DESIGNATED_HITTER = 'usesDesignatedHitter';

    protected $fillable = [
        self::FIELD_GUID,
        self::FIELD_LEAGUE_GUID,
        self::FIELD_NAME,
        self::FIELD_USES_DESIGNATED_HITTER
    ];

    protected $hidden = [self::FIELD_GUID];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GUID;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = self::FIELD_GUID;

    public $timestamps = false;


    function league(): BelongsTo {
        return $this->belongsTo(League::class, League::FIELD_GUID, self::FIELD_GUID);
    }

    function division(): HasMany {
        return $this->hasMany(Division::class, Division::FIELD_GUID, self::FIELD_GUID);
    }

}
