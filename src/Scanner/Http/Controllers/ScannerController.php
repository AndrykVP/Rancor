<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Services\EntryParseService;
use AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry;
use AndrykVP\Rancor\Scanner\Http\Requests\UploadScan;

class ScannerController extends Controller
{

    /**
     * Show the form for searching a scanner entry.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Entry::class);
        $entries = Entry::with('contributor')->paginate(config('rancor.pagination'));

        return view('rancor::scanner.index', compact('entries'));
    }

    /**
     * Show the form for searching a scanner entry.
     *
     * @param \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $this->authorize('view', $entry);
        $entry->load('contributor', 'changelog.contributor');

        return view('rancor::scanner.show', compact('entry'));
    }
}
