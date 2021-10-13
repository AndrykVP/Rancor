<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Http\Requests\EntryForm;
use AndrykVP\Rancor\Scanner\Http\Requests\EntrySearch;
use AndrykVP\Rancor\Scanner\Models\Entry;

class EntryController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Entry',
        'route' => 'entries'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Entry::class);
        $resource = $this->resource;
        $models = Entry::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('resource', 'models'));
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
        $entry->load('territory', 'contributor', 'changelog.contributor');

        return view('rancor::show.entries', compact('entry'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\EntrySearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(EntrySearch $request)
    {
        $this->authorize('viewAny', Entry::class);
        
        $resource = $this->resource;
        $param = $request->validated();
        $models = Entry::where($param['attribute'],'like', $param['value'].'%')->paginate(config('rancor.pagination'));

        session()->flashInput($request->input());
        return view('rancor::resources.index', compact('models', 'resource'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Entry::class);
        $resource = $this->resource;
        $form = $this->form();

        return view('rancor::resources.create', compact('resource', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\EntryForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryForm $request)
    {
        $this->authorize('create',Entry::class);
        $entry = Entry::create($request->validated());

        return redirect(route('admin.entries.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'created']
        ]);
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
        $resource = $this->resource;
        $form = $this->form();
        $model = $entry;

        return view('rancor::resources.edit',compact('resource', 'form', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\EntryForm  $request
     * @param  \AndrykVP\Rancor\Scanner\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryForm $request, Entry $entry)
    {
        $this->authorize('update', $entry);
        $entry->update($request->validated());

        return redirect(route('admin.entries.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'updated']
        ]);
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

        return redirect(route('admin.entries.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'deleted']
        ]);
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
            'selects' => [
                [
                    'name' => 'alliance',
                    'label' => 'IFF Status',
                    'attributes' => 'required',
                    'multiple' => false,
                    'options' => [
                        (object)[
                            'id' => 1,
                            'name' => 'Friend'
                        ],
                        (object)[
                            'id' => 0,
                            'name' => 'Neutral'
                        ],
                        (object)[
                            'id' => -1,
                            'name' => 'Enemy'
                        ],
                    ],
                ],
            ],
        ];
    }
}
