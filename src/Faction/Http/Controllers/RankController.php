<?php

namespace AndrykVP\Rancor\Faction\Http\Controllers;

use AndrykVP\Rancor\Faction\Rank;
use AndrykVP\Rancor\Faction\Http\Requests\RankForm;
use AndrykVP\Rancor\Faction\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RankController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Rank',
        'route' => 'ranks'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Rank::class);

        $resource = $this->resource;
        $models = Rank::paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Rank::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST',],$this->form());
        return view('rancor::resources.create', compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\RankForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RankForm $request)
    {
        $this->authorize('create', Rank::class);

        $data = $request->validated();
        $rank = Rank::create($data);

        return redirect(route('admin.ranks.index'))->with('alert','Rank "'.$rank->name.'" has been successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Faction\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function show(Rank $rank)
    {
        $this->authorize('view', $rank);

        $rank->load('department','users');

        return view('rancor::show.rank', compact('rank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Faction\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function edit(Rank $rank)
    {
        $this->authorize('update', $rank);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH',],$this->form());
        $model = $rank;
        return view('rancor::resources.edit', compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Http\Requests\RankForm  $request
     * @param  \AndrykVP\Rancor\Faction\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function update(RankForm $request, Rank $rank)
    {
        $this->authorize('update', $rank);

        $data = $request->validated();
        $rank->update($data);

        return redirect(route('admin.ranks.index'))->with('alert','Rank "'.$rank->name.'" has been successfully updated.');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Faction\Rank  $rank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rank $rank)
    {
        $this->authorize('delete', $rank);
        
        $rank->delete();

        return redirect(route('admin.ranks.index'))->with('alert','Rank "'.$rank->name.'" has been successfully deleted.');
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
            'selects' => [
                [
                    'name' => 'department_id',
                    'label' => 'Department',
                    'attributes' => 'required',
                    'multiple' => false,
                    'options' => Department::orderBy('name')->get(),
                ],
            ]
        ];
    }
}
