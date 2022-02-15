<?php

namespace Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Group;
use Rancor\Forums\Http\Resources\GroupResource;
use Rancor\Forums\Http\Requests\GroupForm;
use Rancor\Forums\Http\Requests\GroupSearch;

class GroupController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(config('rancor.pagination'));

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\GroupForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupForm $request)
    {
        $this->authorize('create',Group::class);
        
        $data = $request->validated();
        $group = Group::create($data);

        return response()->json([
            'message' => 'Group "'.$group->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Forums\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $this->authorize('view',$group);
        $group->load('users','boards');

        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\GroupForm  $request
     * @param  \Rancor\Forums\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupForm $request, Group $group)
    {
        $this->authorize('update',$group);
        
        $data = $request->validated();
        $group->update($data);

        return response()->json([
            'message' => 'Group "'.$group->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Forums\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete',$group);
        
        $group->delete();

        return response()->json([
            'message' => 'Group "'.$group->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Forums\Http\Requests\GroupSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(GroupSearch $request)
    {
        $this->authorize('viewAny',Group::class);
        $search = $request->validated();        
        $groups = Group::where($search['attribute'], 'like' , '%' . $search['value'] . '%')
                    ->paginate(config('rancor.pagination'));

        return GroupResource::collection($groups);
    }
}