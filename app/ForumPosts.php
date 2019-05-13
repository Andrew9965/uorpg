<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPosts extends Model
{
    protected $table = "phpbb_posts";

    protected $connection = "mysql4";

    protected $primaryKey = 'post_id';

    protected $attributes = [
        'icon_id' => 0,
        'post_approved' => 1,
        'post_reported' => 0,
        'enable_bbcode' => 1,
        'enable_smilies' => 1,
        'enable_magic_url' => 1,
        'enable_sig' => 1,
        'post_attachment' => 0,
        'bbcode_bitfield' => '80A=',
        'post_postcount' => 1,
        'post_edit_time' => 0,
        'post_edit_reason' => '',
        'post_edit_user' => 0,
        'post_edit_count' => 0,
        'post_edit_locked' => 0
    ];

    public $timestamps = false;

    protected $fillable = [
        'topic_id','forum_id','poster_id','icon_id','poster_ip','post_time','post_approved',
        'post_reported','enable_bbcode','enable_smilies','enable_magic_url','enable_sig','post_username',
        'post_subject','post_text','post_checksum','post_attachment','bbcode_bitfield','bbcode_uid',
        'post_postcount','post_edit_time','post_edit_reason','post_edit_user','post_edit_count','post_edit_locked'
    ];
}
