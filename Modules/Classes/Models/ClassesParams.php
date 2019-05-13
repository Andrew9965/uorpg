<?php

namespace Modules\Classes\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class ClassesParams extends Model
{
    use Lang;

    protected $table = 'classes_params';

    protected $fillable = [
        "class_id",
        "active",
        "title",
        "parameters"
    ];

    protected $casts = [
        "class_id"=>"integer",
        "active"=>"integer",
        "title"=>"array",
        "parameters"=>"array",
    ];

    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /*public function getParametersAttribute($value)
    {
        return implode(',', \GuzzleHttp\json_decode($value));
    }*/
}
