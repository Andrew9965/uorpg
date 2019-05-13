<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumTopics extends Model
{
    protected $table = "phpbb_topics";

    protected $connection = "mysql4";

    protected $primaryKey = 'topic_id';

    protected $attributes = [
        "icon_id" => 0,
        "topic_attachment" => 0,
        "topic_approved" => 1,
        "topic_reported" => 0,
        "topic_time_limit" => 0,
        "topic_views" => 0,
        "topic_replies" => 0,
        "topic_replies_real" => 0,
        "topic_status" => 0,
        "topic_type" => 0,
        "topic_first_poster_colour" => "",
        "topic_last_poster_colour" => "",
        "topic_moved_id" => 0,
        "topic_bumped" => 0,
        "topic_bumper" => 0,
        "poll_title" => "",
        "poll_start" => 0,
        "poll_length" => 0,
        "poll_max_options" => 1,
        "poll_last_vote" => 0,
        "poll_vote_change" => 0
    ];

    public $timestamps = false;

    protected $fillable = [
        "forum_id","icon_id","topic_attachment","topic_approved","topic_reported",
        "topic_title","topic_poster","topic_time","topic_time_limit","topic_views",
        "topic_replies","topic_replies_real","topic_status","topic_type","topic_first_post_id",
        "topic_first_poster_name","topic_first_poster_colour","topic_last_post_id",
        "topic_last_poster_id","topic_last_poster_name","topic_last_poster_colour",
        "topic_last_post_subject","topic_last_post_time","topic_last_view_time",
        "topic_moved_id","topic_bumped","topic_bumper","poll_title","poll_start",
        "poll_length","poll_max_options","poll_last_vote","poll_vote_change"
    ];
}
