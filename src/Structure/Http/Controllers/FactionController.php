<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers;

use AndrykVP\Rancor\Structure\Faction;
use AndrykVP\Rancor\Structure\Http\Requests\FactionForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FactionController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Faction',
        'route' => 'factions'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Faction::class);

        $resource = $this->resource;
        $models = Faction::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Faction::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\FactionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FactionForm $request)
    {
        $this->authorize('create', Faction::class);

        $data = $request->validated();
        $faction = Faction::create($data);

        return redirect(route('admin.factions.index'))->with('alert','Faction "'.$faction->name.'" has been successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction)
    {
        $this->authorize('view', $faction);

        $faction->load('departments','ranks');

        return view('rancor::show.faction', compact('faction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function edit(Faction $faction)
    {
        $this->authorize('update', $faction);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $faction;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\FactionForm  $request
     * @param  \AndrykVP\Rancor\Structure\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function update(FactionForm $request, Faction $faction)
    {
        $this->authorize('update', $faction);

        $data = $request->validated();
        $faction->update($data);

        return redirect(route('admin.factions.index'))->with('alert','Faction "'.$faction->name.'" has been successfully updated.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faction $faction)
    {
        $this->authorize('delete', $faction);
        
        $faction->delete();

        return redirect(route('admin.factions.index'))->with('alert','Faction "'.$faction->name.'" has been successfully deleted.');
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
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
            ],
        ];
    }
}
