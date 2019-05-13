<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class PageCollapse extends Model
{
    use Lang;

    protected $table = 'page_collapse';

    protected $fillable = [
        'img',
        'title',
        'description',
        'content',
        'active',
        'page_id',
        'folder',
        'color',
    ];

    protected $casts = [
        "title" => "array",
        "description" => "array",
        "content" => "array"
    ];

    public function getImgAttribute($img)
    {
        if($img) return asset($img);
        else return false;
    }

}
