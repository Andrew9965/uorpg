<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class ForumNewThemes extends Model
{
    use Lang;

    protected $table = 'forum_new_themes';

    protected $fillable = [
        'forum_link', 'title', 'author', 'active'
    ];

    protected $casts = [
        'title' => 'array'
    ];
    
}
