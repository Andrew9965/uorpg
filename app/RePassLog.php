<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RePassLog extends Model
{
    protected $connection = "mysql3";

    protected $table = "RENEW_PASS_CHANGE_LOG";

    protected $fillable = [
        'LOGIN', 'ACTID', 'MAIL', 'TIME', 'IP', 'UPDATED'
    ];

    public $timestamps = false;

    protected $primaryKey = 'ID';
}
