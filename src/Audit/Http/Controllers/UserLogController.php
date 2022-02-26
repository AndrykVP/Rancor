<?php

namespace Rancor\Audit\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

class UserLogController extends Controller
{
<<<<<<< HEAD
	/**
	 * Display a listing of user changelogs.
	 *
	 * @param \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function users(User $user)
	{
		$this->authorize('view', $user);
		$logs = $user->userLog()->with('creator')->get();

		return response()->json($logs, 200);
	}

	/**
	 * Display a listing of ip logs.
	 *
	 * @param \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function ips(User $user)
	{
		$this->authorize('view', $user);
		$ips = $user->ipLog()->with('creator')->get();

		return response()->json($ips, 200);
	}
=======
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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}