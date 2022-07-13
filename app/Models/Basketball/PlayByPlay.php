<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Model;

class PlayByPlay extends Model
{
    protected $fillable = [
        'GameID',
        'Half',
        'PlayNum',
        'Time',
        'Seconds',
        'PlayerID',
        'PlayTypeID',
        'HomeScore',
        'AwayScore',
        'Team',
        'SecondsTaken',
        'HomeLineup',
        'AwayLineup',
        'Name',
        'Posession',
        'SquareX',
        'SquareY',
        'RectX',
        'RectY',
        'PlayByPlayID'
    ];

    protected $connection = 'mysql';
    protected $table = 'PlayByPlay';
    public $timestamps = false;

    function Game() {
        return $this->HasOne('App\Models\Basketball\Game', 'GameID', 'GameID');
    }

}
