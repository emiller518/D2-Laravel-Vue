<?php

namespace App\Models\SuperMegaBaseball;

use Illuminate\Database\Eloquent\Model;

class PlayerAttributes extends Model
{
    protected $fillable = [
        'baseballPlayerLocalID',
        'optionKey',
        'optionValue',
        'optionType'
    ];

    protected $connection = 'sqlite';
    protected $table = 't_baseball_player_options';

    protected $primaryKey = 'baseballPlayerLocalID';
    public $incrementing = false;

    public $timestamps = false;

}
