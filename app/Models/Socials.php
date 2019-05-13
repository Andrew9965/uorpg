<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Socials extends Model
{
    use Lang;

    protected $fillable = [
        'title', 'url', 'img_header', 'img_footer', 'show_header', 'show_footer', 'active'
    ];

    protected $casts = [
        'title' => 'array',
        'url' => 'array'
    ];

}
