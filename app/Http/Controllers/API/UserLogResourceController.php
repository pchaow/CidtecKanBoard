<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\UserBoardController;
use App\Http\Requests\UserBoardRequest;
use App\Http\Requests\UserRequest;
use App\Models\ActivityLog;
use App\Models\Board;
use App\Models\BoardStatus;
use App\Models\Lane;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserLogResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ActivityLog
     */
    public function index(Request $request, $userId = null, $boardId = null, $cardId = null)
    {
        $list_logs = [];
        if (isset($userId) && isset($boardId) && isset($cardId)) {
            /** @var ActivityLog $list_logs */
            $list_logs = ActivityLog::query()
                ->whereBoardId($boardId)
                ->whereCardId($cardId)
                ->get();

        }
        return $list_logs;
    }

}
