<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'PlayerID',
        'Name',
        'City',
        'State',
        'Foreign',
        'PreviousSchool'
    ];

    protected $connection = 'mysql';
    protected $table = 'Player';
    protected $primaryKey = 'PlayerID';
    public $timestamps = false;

    function PlayerYear() {
        return $this->hasMany('App\Models\Basketball\PlayerYear', 'PlayerID');
    }

}
