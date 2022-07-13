<?php

namespace App\Models\SuperMegaBaseball\Pivot;

use App\Models\SuperMegaBaseball\League\Division;
use App\Models\SuperMegaBaseball\Team\Team;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DivisionTeam extends Pivot
{

    use HasUUID;

    const TABLE = 't_division_teams';

    const FIELD_DIVISION_GUID = 'divisionGUID';
    const FIELD_TEAM_GUID = 'teamGUID';

    protected $fillable = [
        self::FIELD_DIVISION_GUID,
        self::FIELD_TEAM_GUID
    ];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $casts = [self::FIELD_DIVISION_GUID => 'string', self::FIELD_TEAM_GUID => 'string'];


    function division(): BelongsTo {
        return $this->belongsTo(Division::class,Division::FIELD_GUID, self::FIELD_DIVISION_GUID);
    }

    function team(): BelongsTo {
        return $this->belongsTo(Team::class, Team::FIELD_GUID, self::FIELD_TEAM_GUID);
    }

}
