<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Http\Resources\GroupResource;
use AndrykVP\Rancor\Forums\Http\Requests\GroupForm;

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
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\GroupForm  $request
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
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
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
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\GroupForm  $request
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
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
     * @param  \AndrykVP\Rancor\Forums\Models\Group  $group
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny',Group::class);
        
        $groups = Group::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return GroupResource::collection($groups);
    }
}