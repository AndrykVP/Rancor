<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Http\Requests\EditEntry;

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

        return view('rancor::resources.index',compact('models','resource'));
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
        return view('rancor::show.entry', compact('entry'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Entry::class);
        
        $resource = $this->resource;
        $models = Entry::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
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
        $form = array_merge(['method' => 'PATCH'], $this->form());
        $model = $entry;

        return view('rancor::resources.edit',compact('model', 'form','resource'));
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

        return redirect(route('scanner.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'updated']);
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

        return redirect(route('scanner.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $entry->name, 'id' => $entry->entity_id, 'action' => 'deleted']);
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
