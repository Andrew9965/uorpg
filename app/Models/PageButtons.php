<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class PageButtons extends Model
{
    use Lang;

    protected $table = 'page_buttons';

    protected $fillable = [
        'page_id', 'title', 'img', 'url', 'target', 'folder', 'active'
    ];

    protected $casts = [
        'title' => 'array'
    ];
    
}
