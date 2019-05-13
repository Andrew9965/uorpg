<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class Classes extends Model
{
    use Lang;

    protected $fillable = [
        "img_id",
        //"lvls",
        "title",
        "description",
        "active"
    ];

    protected $casts = [
        "img_id"=>"string",
        //"lvls"=>"integer",
        "title"=>"array",
        "description"=>"array",
        "active"=>"integer"
    ];

    public function params()
    {
        return $this->hasMany(ClassesParams::class, 'class_id')->where('active', 1);
    }

    public function skills()
    {
        return $this->hasMany(ClassesSkills::class, 'class_id')->where('active', 1);
    }
}
