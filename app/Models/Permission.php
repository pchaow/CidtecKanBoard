<?php

namespace App\Models;

use Laratrust\LaratrustPermission;

class Permission extends LaratrustPermission
{

  //get all roles
  public function roles()
 {
     return $this->belongsToMany('App\Models\Role','permission_role','permission_id','role_id');
 }
}
