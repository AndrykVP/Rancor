<?php

namespace AndrykVP\Rancor\Audit\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Http\Resources\LogResource;

class UserLogController extends Controller
{
    /**
     * Display a listing of user changelogs.
     *
     * @param \Illuminate\Http\Response $response
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request, $id)
    {
        $query = DB::table('changelog_users')
                    ->where('user_id',$id)
                    ->latest()
                    ->leftJoin('users','changelog_users.updated_by','=','users.id')
                    ->select('changelog_users.action','users.id','users.name','changelog_users.created_at','changelog_users.color')
                    ->latest()
                    ->get();

        return [
            'data' => $query
        ];
    }

    /**
     * Display a listing of ip logs.
     *
     * @param \Illuminate\Http\Response $response
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function ips(Request $request, $id)
    {
        $query = DB::table('changelog_ips')
                    ->where('user_id',$id)
                    ->latest()
                    ->get();

        return [
            'data' => $query
        ];
    }
}