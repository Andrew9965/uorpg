<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Videos extends Model
{
    use Lang;

    protected $fillable = [
        "code","img","title","active"
    ];

    protected $casts = [
        "code"=>"string",
        "img"=>"string",
        "title"=>"array",
        "active"=>"integer"
    ];
}
