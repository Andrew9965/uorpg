<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Images extends Model
{
    use Lang;

    protected $fillable = [
        "img","title","active"
    ];

    protected $casts = [
        "img"=>"string",
        "title"=>"array",
        "active"=>"integer"
    ];

}
