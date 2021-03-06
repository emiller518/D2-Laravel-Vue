<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Model;

class PlayerStats extends Model
{
    protected $fillable = [
        'GameID',
        'PlayerID',
        'Minutes',
        '3PMade',
        '3PAttempts',
        'FTMade',
        'FTAttempts',
        'OffReb',
        'DefReb',
        'Rebounds',
        'Assists',
        'Steals',
        'Blocks',
        'Turnovers',
        'Fouls',
        'Points',
        'Starter',
        'PlayerStatsID',
        'PlusMinusOn',
        'PlusMinusOff'
    ];

    protected $connection = 'mysql';
    protected $table = 'PlayerStats';
    public $timestamps = false;

    function Player() {
        return $this->belongsTo('App\Models\Basketball\Player', 'PlayerID', 'PlayerID', 'PlayerID');
    }

    function Game() {
        return $this->belongsTo('App\Models\Basketball\Game', 'GameID', 'GameID', 'GameID');
    }

}
