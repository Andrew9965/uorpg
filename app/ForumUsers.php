<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumUsers extends Model
{
    protected $table = "phpbb_users";

    protected $connection = "mysql4";

    protected $primaryKey = 'user_id';
}
