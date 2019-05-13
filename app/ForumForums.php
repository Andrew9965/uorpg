<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumForums extends Model
{
    protected $fillable = [
        "forum_last_post_id",
        "forum_last_poster_id",
        "forum_last_post_subject",
        "forum_last_post_time",
        "forum_last_poster_name",
        "forum_last_poster_colour"
    ];

    protected $table = "phpbb_forums";

    protected $connection = "mysql4";

    protected $primaryKey = 'forum_id';

    public $timestamps = false;
}
