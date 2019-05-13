<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $connection = "mysql2";

    protected $table = "PLAYERS2";

    protected $fillable = [
        "ID","ONLINE","LOGIN","UNIQ","NICK","LEVEL","CLASS","PFORCE","TM","IP","EXP","FAME","TIMEINGAME","COUNTRY"
    ];

    public $timestamps = false;

    protected $primaryKey = "ID";
}
