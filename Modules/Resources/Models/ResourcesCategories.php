<?php

namespace Modules\Resources\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class ResourcesCategories extends Model
{
    use Lang;

    protected $table = 'resources_categories';

    protected $fillable = ["title","active","description"];

    protected $casts = [
        "title" => "array",
        "description" => "array",
        "active" => "integer"
    ];

    public function items()
    {
        return $this->hasMany(\Modules\Resources\Models\Resources::class, 'category', 'id')->where('active', 1);
    }
}
