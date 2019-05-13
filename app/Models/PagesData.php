<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PagesData extends Model
{

    protected $table = 'pages_data';

    protected $fillable = ["page_id", "data", "active"];

    protected $casts = ["page_id" => "integer", "data" => "array", "active" => "integer"];
}
