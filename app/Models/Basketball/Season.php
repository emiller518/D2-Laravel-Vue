<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'SeasonID',
        'Name',
        'StartDate',
        'EndDate'
    ];

    protected $table = 'Season';
    public $timestamps = false;


}
