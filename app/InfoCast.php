<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoCast extends Model
{
    protected $connection = "mysql2";

    protected $table = "INFOCAST";

    public function getCOLORAttribute($color)
    {
        return $color=='#FFFFFF' ? '#90876b' : $color;
    }
}
