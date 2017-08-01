<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Card;
use App\Models\Lane;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function Log($action = null, $data = [])
    {

        switch ($action) {
            case ActivityLog::ACTION_TYPE_MOVE_CARD :
                $this->logCard($action, $data);
                break;
            case ActivityLog::ACTION_TYPE_UPDATE_CARD :
                $this->logCard($action, $data);
                break;
            case ActivityLog::ACTION_TYPE_DELETE_CARD :
                $this->logCard($action, $data);
                break;
            case ActivityLog::ACTION_TYPE_ADD_CARD :
                $this->logCard($action, $data);
                break;
            default :
                break;
        }
    }

    private function logCard($action = null, $data = null)
    {
        try {
            if (isset($action) && isset($data) && is_array($data)
                && array_key_exists(ActivityLog::LOG_USER_ID, $data)
                && array_key_exists(ActivityLog::LOG_CARD_ID, $data)
                && array_key_exists(ActivityLog::LOG_BOARD_ID, $data)
            ) {
                $action_temp = ['action' => $action];
                $data = array_merge($data, $action_temp);
                /** @var ActivityLog $act_move */
                $act_move = new ActivityLog();
                $act_move->fill($data);
                $act_move->save();

                /** @var User $user */
                $user = User::find($data[ActivityLog::LOG_USER_ID]);
                /** @var Card $card */
                $card = Card::find($data[ActivityLog::LOG_CARD_ID]);
                /** @var Lane $lane_form */
                $lane_form = Lane::find($data[ActivityLog::LOG_LANE_FROM]);

                $message = 'Card Action : ' . $user->name . ' ' . $action . ' ' . $card->name;
                if ($action === ActivityLog::ACTION_TYPE_MOVE_CARD) {
                    $message = 'Card Action : ' . $user->name . ' ' . $action . ' ' . $card->name .'from '. $lane_form->name . ' to ' . $card->lane->name;
                }

                Log::info($message);
            }
        } catch (\Exception $e) {
            Log::error($action . " : " . $e->getMessage());
        }
    }
}
