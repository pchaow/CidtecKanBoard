<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoardUser
 *
 * @mixin \Eloquent
 * @property int $boards_id
 * @property int $users_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardUser whereBoardsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BoardUser whereUsersId($value)
 */
class BoardUser extends Model
{
      protected $table = 'board_user';
      public  $timestamps  = false;
}
