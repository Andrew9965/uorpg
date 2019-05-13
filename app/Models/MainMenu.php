<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $fillable = [
        'title_ru', 'title_en', 'url', 'priority', 'is_active', 'parent_id', 'is_dropdown'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_dropdown' => 'boolean',
    ];

    /*
     * Relation
     */
    public function subMenus()
    {
        return $this->hasMany('App\Models\MainMenu', 'parent_id')->orderBy('priority', 'DESC');
    }

    /*
     * Get
     */
    public function getAllWithAllRelation()
    {
        return $this->where('is_active', '1')
            ->whereNull('parent_id')
            ->orderBy('priority', 'DESC')
            ->with(['subMenus' => function ($q) {
                $q->where('is_active', '1');
            }])
            ->get();
    }
}
