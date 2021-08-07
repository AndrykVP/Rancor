<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Http\Requests\EditEntry;
use AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry;
use AndrykVP\Rancor\Scanner\Http\Requests\UploadScan;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Services\EntryParseService;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Entry::class);

        $entries = Entry::paginate(config('rancor.pagination'));

        return view('rancor::entries.index', compact('entries'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $this->authorize('view', $entry);

        $entry->load('contributor','changelog.contributor')->loadCount('changelog');
        return view('rancor::entries.show', compact('entry'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\SearchEntry  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchEntry $request)
    {
        $this->authorize('viewAny', Entry::class);
        
        $param = $request->validated();
        $entries = Entry::where($param['attribute'],'like', $param['value'].'%')->paginate(config('rancor.pagination'));

        session()->flashInput($request->input());
        return view('rancor::entries.index', compact('entries'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        $this->authorize('update', $entry);

        return view('rancor::entries.edit',compact('entry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\EditEntry  $request
     * @param  \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EditEntry $request, Entry $entry)
    {
        $this->authorize('update', $entry);

        $data = $request->validated();
        $entry->update($data);

        return redirect(route('scanner.entries.index'))->with('alert', ['model' => 'Entry', 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $this->authorize('delete', $entry);
        $entry->delete();

        return redirect(route('scanner.entries.index'))->with('alert', ['model' => 'Entry', 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'deleted']);
    }

    /**
     * Variable for Form fields used in Create and Edit Views
     * 
     * @var array
     */
    protected function form()
    {
        return [
            'inputs' => [
                [
                    'name' => 'name',
                    'label' => 'Name',
                    'type' => 'text',
                    'attributes' => 'autofocus required'
                ],
                [
                    'name' => 'entity_id',
                    'label' => 'Entity ID',
                    'type' => 'number',
                    'attributes' => 'required'
                ],
                [
                    'name' => 'type',
                    'label' => 'Type',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
                [
                    'name' => 'owner',
                    'label' => 'Owner',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
            ],
        ];
    }
}
