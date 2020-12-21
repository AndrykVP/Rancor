<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Entry;
use AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for searching a scanner entry.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Entry::class);

        return view('rancor::scanner.search');
    }
    
    /**
     * Display the results of the search.
     *
     * @param \AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchEntry $request)
    {
        $this->authorize('viewAny', Entry::class);

        $param = $request->validated();
        $query = Entry::where($param['attribute'],'like', $param['value'].'%')->paginate(15);

        return view('rancor::scanner.search',compact('query'));
    }
}
