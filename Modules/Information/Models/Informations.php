<?php

namespace Modules\Information\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Informations extends Model
{
    use Lang;

    protected $fillable = [
        "img_id",
        "url",
        "title"
    ];

    protected $casts = [
        "img_id"=>"string",
        "url"=>"string",
        "title"=>"array"
    ];

}
