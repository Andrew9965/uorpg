<?php

namespace Modules\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class Resources extends Model
{
    use Lang;

    protected $fillable = [
        "category",
        "img_id",
        "title",
        "character_level",
        "skills_for_extraction",
        "skills_for_processing",
        "description",
        "active"
    ];

    protected $casts = [
        "category"=>"integer",
        "img_id"=>"string",
        "title"=>"array",
        "character_level"=>"integer",
        "skills_for_extraction"=>"float",
        "skills_for_processing"=>"float",
        "description"=>"array",
        "active"=>"integer"
    ];
}
