<?php

namespace Modules\Fractions\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class FractionsCategories extends Model
{
    use Lang;

    protected $table = 'fractions_categories';

    protected $fillable = [
        "title",
        "description",
        "class",
        "active"
    ];

    protected $casts = [
        "title"=>"array",
        "description"=>"array",
        "class"=>"string",
        "active"=>"integer"
    ];

    public function fractions()
    {
        return $this->hasMany(Fractions::class, 'category_id')->where('active', 1);
    }

}
