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
 * @property int|null $lane_id
 * @property int|null $lane_from
 * @property-read mixed $card
 * @property-read mixed $lane
 * @property-read mixed $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereLaneFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLog whereLaneId($value)
 */
class ActivityLog extends Model
{
    const ACTION_TYPE_ADD_BOARD = "Added Card";
    const ACTION_TYPE_UPDATE_BOARD = "Updated Card";
    const ACTION_TYPE_DELETE_BOARD = "Deleted Board";
    const ACTION_TYPE_CLOSE_BOARD = "Closed Board";
    const ACTION_TYPE_REOPEN_BOARD = "Reopened Board";
    const ACTION_TYPE_ADD_LANE = "Added Lane";
    const ACTION_TYPE_UPDATE_LANE = "Updated Lane";
    const ACTION_TYPE_DELETE_LANE = "Deleted Lane";
    const ACTION_TYPE_ADD_CARD = "Added Card";
    const ACTION_TYPE_UPDATE_CARD = "Updated Card";
    const ACTION_TYPE_DELETE_CARD = "Deleted Card";
    const ACTION_TYPE_MOVE_CARD = "Moved Card";

    const LOG_USER_ID = 'user_id';
    const LOG_BOARD_ID = 'board_id';
    const LOG_CARD_ID = 'card_id';
    const LOG_LANE_ID = 'lane_id';
    const LOG_LANE_FROM = 'lane_from';

    protected $fillable = ['action', 'user_id', 'board_id', 'card_id', 'lane_id', 'lane_from'];

    protected $appends = ['card', 'lane', 'user' , 'from_lane'];

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

    public function getFromLaneAttribute()
    {
        $lane_from = [];
        if (isset($this->lane_from)) {
            /** @var Lane $lane_from */
            $lane_from = Lane::find($this->lane_from);
        }
        return $lane_from;
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
