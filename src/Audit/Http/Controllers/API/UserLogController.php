<?php

namespace AndrykVP\Rancor\Audit\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserLogController extends Controller
{
    /**
     * Display a listing of user changelogs.
     */
    public function users(User $user): JsonResponse
    {
        $this->authorize('viewLogs', $user);
        $logs = $user->userLog()->with('creator')->paginate(config('rancor.pagination'));

        return response()->json($logs, 200);
    }

    /**
     * Display a listing of ip logs.
     */
    public function ips(User $user): JsonResponse
    {
        $this->authorize('viewLogs', $user);
        $logs = $user->ipLog()->with('creator')->paginate(config('rancor.pagination'));

        return response()->json($logs, 200);
    }
}