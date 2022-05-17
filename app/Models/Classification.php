<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        'ClassID',
        'ClassName',
        'Abbreviation'
    ];

    protected $table = 'Class';
    public $timestamps = false;


}
