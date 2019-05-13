<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Creation extends Model
{
    use Lang;

    protected $table = 'creation';

    protected $fillable = [
        "img","code","type","title","active"
    ];

    protected $casts = [
        "img"=>"string",
        "code"=>"string",
        "type"=>"string",
        "title"=>"array",
        "active"=>"integer"
    ];

}
