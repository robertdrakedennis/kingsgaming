<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $connection = 'mysql5';

    protected $dates = ['last_played'];
}
