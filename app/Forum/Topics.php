<?php

namespace App\Forum;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = "phpbb_topics";

    protected $connection = "mysql4";
}
