<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'TeamID',
        'Name',
        'Abbreviation',
        'College',
        'Mascot',
        'City',
        'State',
        'Division',
        'Conference',
        'Website',
        'Active'
    ];

    protected $table = 'Team';
    protected $primaryKey = 'TeamID';
    public $timestamps = false;

    function playeryear() {
        return $this->belongsTo('PlayerYear', 'TeamID');
    }

}
