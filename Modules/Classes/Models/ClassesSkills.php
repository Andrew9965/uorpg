<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class ClassesSkills extends Model
{
    use Lang;

    protected $table = 'classes_skills';

    protected $fillable = [
        "class_id",
        "active",
        "title",
        "parameters",
        "color"
    ];

    protected $casts = [
        "class_id"=>"integer",
        "active"=>"integer",
        "title"=>"array",
        "parameters"=>"array",
        "color"=>"string"
    ];

    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
