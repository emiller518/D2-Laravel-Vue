<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerYear extends Model
{
    protected $fillable = [
        'PlayerID',
        'TeamID',
        'SeasonID',
        'ClassID',
        'Number',
        'Height',
        'Position',
        'PlayerYearID'
    ];

    protected $table = 'PlayerYear';
    public $timestamps = false;

    function Player() {
        return $this->belongsTo('Player', 'PlayerID');
    }

    function Team(){
        return $this->hasOne('App\Models\Team', 'TeamID', 'TeamID');
    }

    function Season(){
        return $this->hasOne('App\Models\Season', 'SeasonID', 'SeasonID');
    }

    function Class(){
        return $this->hasOne('App\Models\Classification', 'ClassID', 'ClassID');
    }


}
