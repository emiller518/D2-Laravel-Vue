<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'SeasonID',
        'Name',
        'StartDate',
        'EndDate'
    ];

    protected $connection = 'mysql';
    protected $table = 'Season';
    public $timestamps = false;


}
