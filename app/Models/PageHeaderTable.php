<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class PageHeaderTable extends Model
{
    use Lang;

    protected $table = 'page_header_table';

    protected $fillable = [
        'page_id', 'folder', 'title', 'content', 'active', 'color'
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array'
    ];

}
