<?php

namespace App\Models\SuperMegaBaseball\Pivot;

use App\Models\SuperMegaBaseball\Player\PlayerOption;
use App\Models\SuperMegaBaseball\Team\Player;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerLocalID extends Pivot
{
    use Uuids;

    const TABLE = 't_baseball_player_local_ids';

    const FIELD_LOCAL_ID = 'localID';
    const FIELD_GUID = 'GUID';

    protected $fillable = [
        self::FIELD_LOCAL_ID,
        self::FIELD_GUID
    ];

    protected $casts = [
        self::FIELD_GUID => 'string'
    ];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_LOCAL_ID;

    public $timestamps = false;

    function Player(): BelongsTo {
        return $this->belongsTo(Player::class, Player::FIELD_GUID, self::FIELD_GUID);
    }

    function PlayerOption(): BelongsTo {
        return $this->belongsTo(PlayerOption::class, PlayerOption::FIELD_LOCAL_ID, self::FIELD_LOCAL_ID);
    }


}
