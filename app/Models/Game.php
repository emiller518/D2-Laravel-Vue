<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'GameID',
        'SeasonID',
        'HomeID',
        'AwayID',
        'WinID',
        'LossID',
        'HomePts',
        'AwayPts',
        'GameDate',
        'Neutral',
        'Exhibition',
        'NonLeague',
        'Ties',
        'LeadChanges',
        'Attendance',
        'NE10Post',
        'NCAAPost',
        'Site'
    ];

    protected $table = 'Game';
    protected $primaryKey = 'GameID';
    public $timestamps = false;

    function WinningTeam() {
        return $this->HasOne('App\Models\Team', 'TeamID', 'WinID');
    }

    function LosingTeam() {
        return $this->HasOne('App\Models\Team', 'TeamID', 'LossID');
    }

    function HomeTeam() {
        return $this->HasOne('App\Models\Team', 'TeamID', 'HomeID');
    }

    function AwayTeam() {
        return $this->HasOne('App\Models\Team', 'TeamID', 'AwayID');
    }

    function PlayerStats(){
            return $this->HasMany('App\Models\PlayerStats', 'GameID', 'GameID');
    }

    function Season(){
        return $this->HasMany('App\Models\Season', 'SeasonID', 'SeasonID');
    }

}
