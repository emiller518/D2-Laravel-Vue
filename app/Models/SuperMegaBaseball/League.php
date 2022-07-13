<?php

namespace App\Models\SuperMegaBaseball;

use Illuminate\Database\Eloquent\Model;
use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{

    use HasUUID;

    protected $fillable = [
        'GUID',
        'originalGUID',
        'name',
        'allowedTeamType'
    ];


    protected $hidden = ['GUID'];

    protected $connection = 'sqlite';
    protected $table = 't_leagues';

    protected $primaryKey = 'GUID';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $uuidFieldName = 'GUID';

    public $timestamps = false;


    function conference(): HasMany {
        return $this->hasMany('App\Models\SuperMegaBaseball\Conference', 'GUID', 'GUID');
    }

}
