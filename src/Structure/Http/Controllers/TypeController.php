<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Structure\Models\Type;
use AndrykVP\Rancor\Structure\Http\Requests\TypeForm;

class TypeController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Type',
        'route' => 'types'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Type::class);

        $resource = $this->resource;
        $models = Type::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Type::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\TypeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeForm $request)
    {
        $this->authorize('create', Type::class);

        $data = $request->validated();
        $type = Type::create($data);

        return redirect(route('admin.types.index'))->with('alert', ['model' => $resource->name, 'name' => $type->name, 'action' => 'created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        $this->authorize('view', $type);

        $type->load('awards');

        return view('rancor::show.type', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        $this->authorize('update', $type);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $type;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\TypeForm  $request
     * @param  \AndrykVP\Rancor\Structure\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(TypeForm $request, Type $type)
    {
        $this->authorize('update', $type);

        $data = $request->validated();
        $type->update($data);

        return redirect(route('admin.types.index'))->with('alert', ['model' => $resource->name, 'name' => $type->name, 'action' => 'updated']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $this->authorize('delete', $type);
        
        $type->delete();

        return redirect(route('admin.types.index'))->with('alert', ['model' => $resource->name, 'name' => $type->name, 'action' => 'deleted']);
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
            ],
            'textareas' => [
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'text',
                    'attributes' => 'row="4"'
                ],
            ],
        ];
    }
}
