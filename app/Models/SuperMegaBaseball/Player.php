<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'GUID',
        'originalGUID',
        'teamGUID',
        'power',
        'contact',
        'speed',
        'fielding',
        'arm',
        'velocity',
        'junk',
        'accuracy',
        'age'
    ];

    protected $connection = 'sqlite';
    protected $table = 't_baseball_players';
    protected $primaryKey = 'GUID';
    public $timestamps = false;

}
