<?php

namespace AndrykVP\Rancor\Audit\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserLogController extends Controller
{
    /**
     * Display a listing of user changelogs.
     *
     * @param \Illuminate\Http\Response  $response
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, User $user)
    {
        $logs = $user->userLog()->with('creator')->get();

        return response()->json($logs, 200);
    }

    /**
     * Display a listing of ip logs.
     *
     * @param \Illuminate\Http\Response $response
     * @param \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function ips(Request $request, User $user)
    {
        $ips = $user->ipLog()->with('creator')->get();

        return response()->json($ips, 200);
    }
}