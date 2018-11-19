<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = ['name', 'display_name', 'description'];


    public function roles()
    {
        return $this->belongsToMany('App\user');
    }
}