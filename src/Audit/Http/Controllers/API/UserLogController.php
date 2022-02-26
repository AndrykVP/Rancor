<?php

namespace Rancor\Audit\Http\Controllers\API;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======
use Illuminate\Http\JsonResponse;
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
use App\Models\User;

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
>>>>>>> 8bd043e14dcbac3ba78d5d48ea033afbdbdeb2d6
}