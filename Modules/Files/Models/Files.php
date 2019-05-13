<?php

namespace Modules\Files\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Files extends Model
{
    use Lang;

    protected $fillable = [
        "category_id",
        "file",
        "title",
        "recomended",
        "size",
        "description",
        "active"
    ];

    protected $casts = [
        "category_id"=>"integer",
        "file"=>"string",
        "title"=>"array",
        "recomended"=>"integer",
        "size"=>"string",
        "description"=>"array",
        "active"=>"integer"
    ];

}
