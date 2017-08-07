<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Board[] $boards
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Board[] $boardsMameber
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cardsMameber
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Card[] $cardsOwner
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRoleIs($role = '')
 * @mixin \Eloquent
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string|null $password
 * @property string $name
 * @property array $profiles
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereProfiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 */
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


    public static function findByUsername($username)
    {
        $user = User::where('username', '=', $username)->first();
        return $user;
    }


}
