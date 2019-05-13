<?php

namespace Modules\Fractions\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Fractions extends Model
{
    use Lang;

    protected $fillable = [
        "category_id",
        "img_id",
        "title",
        "description",
        "signature",
        "class",
        "active"
    ];

    protected $casts = [
        "category_id"=>"integer",
        "img_id"=>"string",
        "title"=>"array",
        "description"=>"array",
        "signature"=>"array",
        "class"=>"string",
        "active"=>"integer"
    ];

}
