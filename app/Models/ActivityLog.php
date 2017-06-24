<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property string|null $action
 * @property int|null $user_id
 * @property int|null $board_id
 * @property int|null $card_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereBoardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereUserId($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Model
{
    const ACTION_TYPE_ADD_BOARD = "add_board";
    const ACTION_TYPE_EDIT_BOARD = "edit_board";
    const ACTION_TYPE_DELETE_BOARD = "delete_board";
    const ACTION_TYPE_CLOSE_BOARD = "close_board";
    const ACTION_TYPE_REOPEN_BOARD = "reopen_board";
    const ACTION_TYPE_ADD_LANE = "add_lane";
    const ACTION_TYPE_EDIT_LANE = "edit_lane";
    const ACTION_TYPE_DELETE_LANE = "delete_lane";
    const ACTION_TYPE_ADD_CARD = "add_card";
    const ACTION_TYPE_EDIT_CARD = "edit_card";
    const ACTION_TYPE_DELETE_CARD = "delete_card";
    const ACTION_TYPE_MOVE_CARD = "move_card";

    const LOG_USER_ID = 'user_id';
    const LOG_BOARD_ID = 'board_id';
    const LOG_CARD_ID = 'card_id';
    const LOG_LANE_ID = 'lane_id';

    protected $fillable = ['action', 'user_id', 'board_id', 'card_id', 'lane_id'];

    protected $appends = ['card', 'lane', 'user'];

    public function getCardAttribute()
    {
        $card = [];
        if (isset($this->card_id)) {
            /** @var Card $card */
            $card = Card::find($this->card_id);
        }
        return $card;
    }

    public function getLaneAttribute()
    {
        $lane = [];
        if (isset($this->lane_id)) {
            /** @var Lane $lane */
            $lane = Lane::find($this->lane_id);
        }
        return $lane;
    }

    public function getUserAttribute()
    {
        $user = [];
        if (isset($this->user_id)) {
            /** @var User $user */
            $user = User::find($this->user_id);
        }
        return $user;
    }


}
