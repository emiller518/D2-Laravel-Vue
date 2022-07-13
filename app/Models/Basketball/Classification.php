<?php

namespace App\Models\Basketball;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        'ClassID',
        'ClassName',
        'Abbreviation'
    ];

    protected $connection = 'mysql';
    protected $table = 'Class';
    public $timestamps = false;


}
