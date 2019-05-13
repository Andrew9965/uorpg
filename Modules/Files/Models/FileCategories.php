<?php

namespace Modules\Files\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class FileCategories extends Model
{
    use Lang;

    protected $table = 'file_categories';

    protected $fillable = [
        "title",
        "append_text",
        "prepend_text",
        "active"
    ];

    protected $casts = [
        "title"=>"array",
        "append_text"=>"array",
        "prepend_text"=>"array",
        "active"=>"integer"
    ];

    public function files()
    {
        return $this->hasMany(Files::class, 'category_id')->where('active', 1);
    }
}
