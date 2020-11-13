<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Log;
use AndrykVP\Rancor\Scanner\Events\EditScan;
use AndrykVP\Rancor\Scanner\Http\Resources\LogResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $this->authorize('view',Log::class);

        $records = Log::with('contributor')->where('entry_id',$id)->latest()->get();

        return LogResource::collection($records);
    }
}
