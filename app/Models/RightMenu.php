<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class RightMenu extends Model
{
    use Lang;

    protected $table = 'right_menu';

    protected $fillable = [
        'title', 'img', 'url', 'target', 'active'
    ];

    protected $casts = [
        'title' => 'array'
    ];


}
