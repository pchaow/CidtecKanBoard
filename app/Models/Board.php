<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Board
 *
 * @property-read \App\Models\BoardStatus $boardStatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lane[] $lanes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $membersBoard
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $user_id
 * @property int $board_status_id
 * @property int $sprint
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereBoardStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereSprint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Board whereUserId($value)
 */
class Board extends Model
{

    protected $fillable = ['name', 'description', 'user_id','sprint'];

    //get list of lanes
    public function lanes()
    {
        return $this->hasMany(Lane::class);
    }

    //get all member in board
    public function membersBoard()
    {
        return $this->belongsToMany('App\Models\User', 'board_user', 'boards_id', 'users_id');
    }

    //get  board owner
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function boardStatus()
    {
        return $this->belongsTo(BoardStatus::class, 'board_status_id');
    }


}
