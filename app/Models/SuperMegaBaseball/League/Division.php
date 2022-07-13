<?php

namespace App\Models\SuperMegaBaseball\League;

use App\Models\SuperMegaBaseball\Pivot\DivisionTeam;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Division extends Model
{

    use HasUUID;

    const TABLE = 't_divisions';

    const FIELD_GUID = 'GUID';
    const FIELD_CONFERENCE_GUID = 'conferenceGUID';
    const FIELD_NAME = 'name';

    protected $fillable = [
        self::FIELD_GUID,
        self::FIELD_CONFERENCE_GUID,
        self::FIELD_NAME
    ];

    protected $hidden = [self::FIELD_GUID];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_GUID;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = self::FIELD_GUID;

    public $timestamps = false;


    function conference(): BelongsTo {
        return $this->belongsTo(Conference::class, Conference::FIELD_GUID, self::FIELD_CONFERENCE_GUID);
    }

    function divisionTeam(): BelongsToMany {
        return $this->belongsToMany(DivisionTeam::class,
                                     DivisionTeam::TABLE,
                            DivisionTeam::FIELD_DIVISION_GUID,
                            self::FIELD_GUID);
    }

}
