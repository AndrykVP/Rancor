<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Http\Requests\TerritoryTypeForm;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;

class TerritoryTypeController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'TerritoryType',
        'route' => 'territorytypes'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',TerritoryType::class);
        $resource = $this->resource;
        $models = TerritoryType::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('resource', 'models'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function show(TerritoryType $territorytype)
    {
        $this->authorize('view', $territorytype);
        $territorytype->loadCount('territories');

        return view('rancor::show.territorytypes', compact('territorytype'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', TerritoryType::class);
        
        $resource = $this->resource;
        $models = TerritoryType::where('name','like', $request->search.'%')->paginate(config('rancor.pagination'));

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
        $this->authorize('create',TerritoryType::class);
        $resource = $this->resource;
        $form = $this->form();

        return view('rancor::resources.create', compact('resource', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\TerritoryTypeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerritoryTypeForm $request)
    {
        $this->authorize('create',TerritoryType::class);
        $territorytype = TerritoryType::create($request->validated());

        return redirect(route('admin.territorytypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'created']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function edit(TerritoryType $territorytype)
    {
        $this->authorize('update', $territorytype);
        $resource = $this->resource;
        $form = $this->form();
        $model = $territorytype;

        return view('rancor::resources.edit',compact('resource', 'form', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\TerritoryTypeForm  $request
     * @param  \AndrykVP\Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function update(TerritoryTypeForm $request, TerritoryType $territorytype)
    {
        $this->authorize('update', $territorytype);
        $territorytype->update($request->validated());

        return redirect(route('admin.territorytypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'updated']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\TerritoryType  $territorytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(TerritoryType $territorytype)
    {
        $this->authorize('delete', $territorytype);
        $territorytype->delete();

        return redirect(route('admin.territorytypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'deleted']
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
                    'name' => 'image',
                    'label' => 'Image URL',
                    'type' => 'url',
                    'attributes' => 'required'
                ],
            ],
        ];
    }
}
