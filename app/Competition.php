<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $connection = "mysql2";

    protected $table = "COMPETITION_WINNER";
}
