<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Entry;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware.web'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Entry::class);

        $entries = Entry::paginate(config('rancor.pagination'));

        return view('rancor::scanner.index',compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Entry::class);

        return view('rancor::scanner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Entry::class);

        abort_if(!$request->hasFile('files'), 400, 'At least 1 XML file must be uploaded.');

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

        return redirect(route('scanner.create'))->with('alert', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $this->authorize('view', $entry);

        $entry->load('contributor','changelog.contributor');
        return view('rancor::scanner.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        $this->authorize('update', $entry);

        return view('rancor::scanner.edit', compact($entry));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\EditEntry  $request
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EditEntry $request, Entry $entry)
    {
        $this->authorize('update', $entry);

        $data = $request->validated();
        $entry->update($data);

        return redirect(route('scanner.index'))->with('alert', "Record for {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) has been updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $this->authorize('delete', $entry);
        $entry->delete();

        return redirect(route('scanner.index'))->with('alert', "All records of the {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) have been successfully deleted.");
    }
}
