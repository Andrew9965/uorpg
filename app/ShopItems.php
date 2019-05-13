<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopItems extends Model
{
    protected $connection = "mysql2";

    protected $table = "SHOPITEMS";

    public function vendor()
    {
        return $this->hasOne(ShopVendors::class, 'ID', 'V_ID');
    }
}
