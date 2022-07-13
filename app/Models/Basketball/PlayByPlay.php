<?php

namespace App\Models;

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

    protected $table = 'PlayByPlay';
    public $timestamps = false;
    protected $connection = 'mysql';

    function Game() {
        return $this->HasOne('App\Models\Game', 'GameID', 'GameID');
    }

}
