<?php

namespace Modules\Page\Models;

use App\Models\PageButtons;
use App\Models\PageCollapse;
use App\Models\PageCollapseItem;
use App\Models\PageHeaderTable;
use Illuminate\Database\Eloquent\Model;
use Lia\Traits\Lang;


class Pages extends Model
{
    use Lang;

    protected $fillable = ["uri","title","content","meta_title","meta_keywords","meta_description","active","control_page"];

    protected $casts = [
        "title"=>"array",
        "content"=>"array",
        "meta_title"=>"array",
        "meta_keywords"=>"array",
        "meta_description"=>"array",
        "control_page"=>"string",
        "type"=>"string"
    ];

    public function getRouteKeyName(){
        return "uri";
    }

    public function collapse()
    {
        return $this->hasMany(PageCollapse::class, 'page_id')->where('active',1);
    }

    public function collapse_item()
    {
        return $this->hasMany(PageCollapseItem::class, 'page_id')->where('active',1);
    }

    public function header_table()
    {
        return $this->hasMany(PageHeaderTable::class, 'page_id')->where('active', 1);
    }

    public function buttons()
    {
        return $this->hasMany(PageButtons::class, 'page_id')->where('active', 1);
    }
}
