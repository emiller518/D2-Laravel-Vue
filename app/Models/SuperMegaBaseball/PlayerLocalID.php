<?php

namespace App\Models\SuperMegaBaseball;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class PlayerLocalID extends Model
{
    use Uuids;

    protected $fillable = [
        'localID',
        'GUID'
    ];

    protected $casts = [
        'GUID' => 'string'
    ];

    protected $hidden = ['GUID'];

    protected $connection = 'sqlite';
    protected $table = 't_baseball_player_local_ids';

    protected $primaryKey = 'localID';

    public $timestamps = false;

    function Player() {
        return $this->belongsTo('App\Models\SuperMegaBaseball\Player', 'GUID', 'GUID');
    }


}
