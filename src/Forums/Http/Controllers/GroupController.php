<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Group;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Http\Requests\GroupForm;

class GroupController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Group',
        'route' => 'groups'
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Group::class);

        $resource = $this->resource;
        $models = Group::paginate(config('rancor.pagination'));
        
        return view('rancor::resources.index',compact('models', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Group::class);
        
        $resource = $this->resource;
        $form = array_merge(['method' => 'POST'], $this->form());

        return view('rancor::resources.create',compact('resource','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\GroupForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupForm $request)
    {
        $this->authorize('create', Group::class);
        
        $data = $request->validated();
        $group = Group::create($data);

        return redirect()->route('admin.groups.index')->with('alert', 'Group "'.$group->name.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $this->authorize('view',$group);
        
        $resource = $this->resource;
        $group->load('users','categories','boards');
   
         return view('rancor::show.group',compact('resource','group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);
        
        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH'], $this->form());
        $model = $group;

        return view('rancor::resources.edit',compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\GroupForm  $request
     * @param  \AndrykVP\Rancor\Forums\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupForm $request, Group $group)
    {
        $this->authorize('update',$group);
        
        $data = $request->validated();
        $group->update($data);

        return redirect()->route('admin.groups.index')->with('alert', 'Group "'.$group->name.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete',$group);
        
        $group->delete();

        return redirect()->route('admin.groups.index')->with('alert', 'Group "'.$group->name.'" has been successfully deleted');
    }

    /**
     * Variable for Form fields used in Create and Edit Views
     * 
     * @var array
     */
    protected function form($board = null)
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
                    'attributes' => 'required',
                ]
            ]
        ];
    }
}