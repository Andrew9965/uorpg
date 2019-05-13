<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegMailInfo extends Model
{
    protected $connection = "mysql2";

    protected $table = "REGMAIL_LOG";

    protected $fillable = [
        'LOGIN', 'PASSWORD', 'EMAIL', 'INFO', 'IP', 'TIME', 'SENDED', 'MSG', 'ACT_CODE'
    ];

    public $timestamps = false;

    protected $primaryKey = 'ID';
}
