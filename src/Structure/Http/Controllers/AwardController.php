<?php

namespace AndrykVP\Rancor\Structure\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Structure\Models\Award;
use AndrykVP\Rancor\Structure\Models\Type;
use AndrykVP\Rancor\Structure\Http\Requests\AwardForm;

class AwardController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Award',
        'route' => 'awards'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Award::class);

        $resource = $this->resource;
        $models = Award::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Award::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AwardForm $request)
    {
        $this->authorize('create', Award::class);

        $data = $request->validated();
        $award = Award::create($data);

        return redirect(route('admin.awards.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $award->name, 'action' => 'created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function show(Award $award)
    {
        $this->authorize('view', $award);

        $award->load('type')->loadCount('users');

        return view('rancor::show.award', compact('award'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Award::class);
        
        $resource = $this->resource;
        $models = Award::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function edit(Award $award)
    {
        $this->authorize('update', $award);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $award;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Http\Requests\AwardForm  $request
     * @param  \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function update(AwardForm $request, Award $award)
    {
        $this->authorize('update', $award);

        $data = $request->validated();
        $award->update($data);

        return redirect(route('admin.awards.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $award->name, 'action' => 'updated']);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Structure\Models\Award  $award
     * @return \Illuminate\Http\Response
     */
    public function destroy(Award $award)
    {
        $this->authorize('delete', $award);
        
        $award->delete();

        return redirect(route('admin.awards.index'))->with('alert', ['model' => $this->resource['name'], 'name' => $award->name, 'action' => 'deleted']);
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
                    'name' => 'code',
                    'label' => 'Code',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
                [
                    'name' => 'levels',
                    'label' => 'Levels',
                    'type' => 'number',
                ],
                [
                    'name' => 'priority',
                    'label' => 'Priority',
                    'type' => 'number',
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
            'selects' => [
                [
                    'name' => 'type_id',
                    'label' => 'Type',
                    'attributes' => 'required',
                    'multiple' => false,
                    'options' => Type::orderBy('name')->get(),
                ],
            ]
        ];
    }
}
