<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', "profiles",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'profiles' => 'array',
    ];

    public function boardsMameber()
    {
        return $this->belongsToMany('App\Models\Board', 'board_user', 'users_id', 'boards_id');
    }

    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function cardsMameber()
    {
        return $this->belongsToMany('App\Models\Card', 'card_user', 'users_id', 'cards_id');
    }

    public function cardsOwner()
    {
        return $this->hasMany('App\Models\Card', 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }
}
