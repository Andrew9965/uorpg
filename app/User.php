<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*
     * Admin
     */

    /*
     * Get Admin
     */

    public function forum_user()
    {
        return $this->hasOne(ForumUsers::class, 'user_id', 'forum_');
    }

    public function getAllP($field, $order_by, $paginate)
    {
        return $this->orderBy($field, $order_by)
            ->paginate($paginate);
    }

    public function getSearchResultP($str, $paginate)
    {
        return $this->search($str, null, true)
            ->paginate($paginate);
    }

    public function getSearchResultRepresentativeP($str, $paginate)
    {
        return $this->search($str, null, true)
            ->where('is_representative', '1')
            ->paginate($paginate);
    }

    public function getUserWithRolesP($field, $order_by, $paginate, $roles)
    {
        if ($roles)
            return $this->whereHas('roles')
                ->with('roles')
                ->paginate($paginate);
        else
            return $this->with('roles')
                ->orderBy($field, $order_by)
                ->paginate($paginate);


    }

    public function getSearchResultWithRolesP($str, $paginate)
    {
        return $this->with('roles')
            ->search($str, null, true)
            ->paginate($paginate);
    }
}
