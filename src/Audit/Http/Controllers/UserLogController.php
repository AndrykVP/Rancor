<?php

namespace AndrykVP\Rancor\Audit\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserLogController extends Controller
{
    /**
     * Display a listing of user changelogs.
     */
    public function users(User $user): View
    {
        $this->authorize('viewLogs', $user);
        $logs = $user->userLog()->with('creator')->get();

        return view('rancor.logs', compact($logs));
    }

    /**
     * Display a listing of ip logs.
     */
    public function ips(User $user): View
    {
        $this->authorize('viewLogs', $user);
        $logs = $user->ipLog()->with('creator')->get();

        return view('rancor.logs', compact($logs));
    }
}