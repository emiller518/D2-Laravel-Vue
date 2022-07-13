<?php

namespace App\Models\Basketball;

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

    protected $connection = 'mysql';
    protected $table = 'Game';
    protected $primaryKey = 'GameID';
    public $timestamps = false;

    function WinningTeam() {
        return $this->HasOne('App\Models\Basketball\Team', 'TeamID', 'WinID');
    }

    function LosingTeam() {
        return $this->HasOne('App\Models\Basketball\Team', 'TeamID', 'LossID');
    }

    function HomeTeam() {
        return $this->HasOne('App\Models\Basketball\Team', 'TeamID', 'HomeID');
    }

    function AwayTeam() {
        return $this->HasOne('App\Models\Basketball\Team', 'TeamID', 'AwayID');
    }

    function PlayerStats(){
            return $this->HasMany('App\Models\Basketball\PlayerStats', 'GameID', 'GameID');
    }

    function Season(){
        return $this->HasMany('App\Models\Basketball\Season', 'SeasonID', 'SeasonID');
    }

}
