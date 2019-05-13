<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accaunts extends Model
{
    protected $connection = "mysql3";

    protected $table = "accaunts";

    protected $fillable = [
        "LOGIN","DELETED","PASSWORD","EMAIL","REFERAL","REG_IP","EMAIL_ACTIVATED","ACC_ACTIVATED",
        "REG_TIME","EMAIL_ACT_TIME","ACTIV_CODE","INFO","NEW_PASSWORD","NEW_PASSWORD_DATE",
        "NEED_PASS_UPDATE","GODSTONE","GODSTONE_CONTROL"
    ];

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = 'LOGIN';
}
