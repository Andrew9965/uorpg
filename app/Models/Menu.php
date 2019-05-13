<?php

namespace App\Models;

use Lia\Traits\AdminBuilder;
use Lia\Traits\ModelTree;
use Lia\Traits\Lang;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use ModelTree, AdminBuilder, Lang;

    protected $table = 'Menu';

    protected $fillable = ['parent_id','order','title','url','target','active'];

    protected $casts = [
        'title' => 'array'
    ];
    
}
