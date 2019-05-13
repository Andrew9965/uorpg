<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class PageCollapseItem extends Model
{
    use Lang;

    protected $table = 'page_collapse_item';

    protected $fillable = [
        'page_id', 'folder', 'color', 'title', 'content', 'active'
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
    ];
    
}
