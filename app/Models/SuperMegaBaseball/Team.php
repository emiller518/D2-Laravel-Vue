<?php

namespace App\Models\SuperMegaBaseball;

use Illuminate\Database\Eloquent\Model;
use BinaryCabin\LaravelUUID\Traits\HasUUID;

class Team extends Model
{

    use HasUUID;

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


    protected $hidden = ['GUID'];

    protected $connection = 'sqlite';
    protected $table = 't_baseball_players';

    protected $primaryKey = 'GUID';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = 'GUID';

    public $timestamps = false;



    function PlayerLocalID() {
        return $this->hasOne('App\Models\SuperMegaBaseball\PlayerLocalID', 'GUID', 'GUID');
    }

}
