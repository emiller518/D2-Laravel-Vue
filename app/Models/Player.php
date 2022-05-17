<?php

namespace App\Models;

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

    protected $table = 'Player';
    protected $primaryKey = 'PlayerID';
    public $timestamps = false;

    function PlayerYear() {
        return $this->hasMany('App\Models\PlayerYear', 'PlayerID');
    }

}
