<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionRole
 *
 * @mixin \Eloquent
 * @property int $permission_id
 * @property int $role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PermissionRole whereRoleId($value)
 */
class PermissionRole extends Model
{
    //
    protected $table = 'permission_role';
}
