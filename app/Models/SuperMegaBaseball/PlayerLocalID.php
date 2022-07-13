<?php

namespace App\Models\SuperMegaBaseball;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
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
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

}
