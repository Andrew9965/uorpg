<?php

namespace Modules\News\Models;

use App\ForumUsers;
use Illuminate\Database\Eloquent\Model;
use Lia\Auth\Database\Administrator;
use Lia\Traits\Lang;


class News extends Model
{
    use Lang;

    protected $fillable = [
        "slug",
        "title",
        "content",
        "forum_link",
        "author_id",
        "active"
    ];

    protected $casts = [
        "slug"=>"string",
        "title"=>"array",
        "content"=>"array",
        "forum_link"=>"array",
        "active"=>"integer",
        "author_id"=>"integer",
    ];

    public function getRouteKeyName(){
        return "slug";
    }

    public function author()
    {
        return $this->hasOne(Administrator::class, 'forum_', 'author_id');
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
