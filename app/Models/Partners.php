<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;

class Partners extends Model
{
    use Lang;

    protected $table = "partners";

    protected $fillable = ['img', 'link', 'target', 'active', 'alt', 'title'];

    protected $casts = [
        'link' => 'array',
        'alt' => 'array',
        'title' => 'array'
    ];
}
