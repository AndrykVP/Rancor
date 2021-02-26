<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Entry;
use AndrykVP\Rancor\Scanner\Services\EntryParseService;
use AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry;
use AndrykVP\Rancor\Scanner\Http\Requests\UploadScan;
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
        $entries = Entry::with('contributor')->paginate(config('rancor.pagination'));

        return view('rancor::scanner.search', compact('entries'));
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
        $entries = Entry::where($param['attribute'],'like', $param['value'].'%')->paginate(15);

        return view('rancor::scanner.search',compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $this->authorize('create',Entry::class);

        return view('rancor::scanner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\UploadScan  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadScan $request)
    {
        $this->authorize('create',Entry::class);

        $scanner = new EntryParseService($request);
        $scanner->start();
        $response = 'Scanner entries have been successfully processed with';
        if($scanner->new > 0)
        {
            $response = $response." {$scanner->new} new entries.";
        }
        if($scanner->updated > 0)
        {
            $response = $response." {$scanner->updated} updated entries.";
        }
        if($scanner->unchanged > 0)
        {
            $response = $response." {$scanner->unchanged} unchanged entries.";
        }

        return redirect(route('scanner.upload'))->with('alert', $response);
    }
}
