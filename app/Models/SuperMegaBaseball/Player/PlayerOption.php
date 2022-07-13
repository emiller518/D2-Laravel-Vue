<?php

namespace App\Models\SuperMegaBaseball\Player;

use App\Models\SuperMegaBaseball\Pivot\PlayerLocalID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlayerOption extends Model
{
    const TABLE = 't_baseball_player_options';

    const FIELD_LOCAL_ID = 'baseballPlayerLocalID';
    const FIELD_OPTION_KEY = 'optionKey';
    const FIELD_OPTION_VALUE = 'optionValue';
    const FIELD_OPTION_TYPE = 'optionType';

    protected $fillable = [
        self::FIELD_LOCAL_ID,
        self::FIELD_OPTION_KEY,
        self::FIELD_OPTION_VALUE,
        self::FIELD_OPTION_TYPE
    ];

    protected $connection = 'sqlite';
    protected $table = self::TABLE;

    protected $primaryKey = self::FIELD_LOCAL_ID;
    public $incrementing = false;

    public $timestamps = false;

    function PlayerLocalID(): HasOne {
        return $this->hasOne(PlayerLocalID::class, PlayerLocalID::FIELD_LOCAL_ID, self::FIELD_LOCAL_ID);
    }

}
