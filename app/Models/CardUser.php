<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardUser extends Model
{
    protected $table = 'card_user';
    public  $timestamps  = false;
    protected $fillable = ['cards_id', 'users_id'];
}
