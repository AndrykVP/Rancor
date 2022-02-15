<?php

namespace AndrykVP\Rancor\Audit\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserLogController extends Controller
{
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
}