<?php

namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    public function getAll()
    {
        return $this->all();
    }
}
