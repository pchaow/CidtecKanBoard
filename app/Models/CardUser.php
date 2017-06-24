<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CardUser
 *
 * @mixin \Eloquent
 * @property int $cards_id
 * @property int $users_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CardUser whereCardsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CardUser whereUsersId($value)
 */
class CardUser extends Model
{
    protected $table = 'card_user';
    public  $timestamps  = false;
    protected $fillable = ['cards_id', 'users_id'];
}
