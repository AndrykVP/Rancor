<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Structure\Models\AwardType;
use AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm;

class AwardTypeController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Award Type',
        'route' => 'awardtypes'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', AwardType::class);

        $resource = $this->resource;
        $models = AwardType::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', AwardType::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AwardTypeForm $request)
    {
        $this->authorize('create', AwardType::class);

        $data = $request->validated();
        $awardtype = AwardType::create($data);

        return redirect(route('admin.awardtypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $awardtype->name, 'action' => 'created']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\AwardType  $awardtype
     * @return \Illuminate\Http\Response
     */
    public function show(AwardType $awardtype)
    {
        $this->authorize('view', $awardtype);

        $awardtype->load('awards');

        return view('rancor::show.awardtype', compact('awardtype'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', AwardType::class);
        
        $resource = $this->resource;
        $models = AwardType::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\AwardType  $awardtype
     * @return \Illuminate\Http\Response
     */
    public function edit(AwardType $awardtype)
    {
        $this->authorize('update', $awardtype);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $awardtype;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardTypeForm  $request
     * @param  \AndrykVP\Rancor\Structure\Models\AwardType  $awardtype
     * @return \Illuminate\Http\Response
     */
    public function update(AwardTypeForm $request, AwardType $awardtype)
    {
        $this->authorize('update', $awardtype);

        $data = $request->validated();
        $awardtype->update($data);

        return redirect(route('admin.awardtypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $awardtype->name, 'action' => 'updated']
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\AwardType  $awardtype
     * @return \Illuminate\Http\Response
     */
    public function destroy(AwardType $awardtype)
    {
        $this->authorize('delete', $awardtype);
        
        $awardtype->delete();

        return redirect(route('admin.awardtypes.index'))->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $awardtype->name, 'action' => 'deleted']
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
