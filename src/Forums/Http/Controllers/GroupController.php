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
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Group::class);

        $groups = Group::with('category')->orderBy('category_id')->orderBy('order')->get();
        
        return view('rancor::Groups.index',compact('Groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Group::class);
        $parentGroup = Group::find($request->Group);
        $selCategory = $parentGroup ? $parentGroup->category : Category::find($request->category);
        $groups = Group::orderBy('title')->get();
        $groups = Group::orderBy('name')->get();
        $categories = Category::orderBy('title')->get();

        return view('rancor::Groups.create',compact('groups','Groups','categories','selCategory','parentGroup'));
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

        $group->groups()->sync($data['groups']);

        return redirect()->route('forums.groups.index')->with('alert', 'Group "'.$group->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Group $group)
    {
        $this->authorize('view',$group);

        $group->load('category','moderators')->load(['children' => function($query) {
            $query->withCount('discussions','replies','children')->with('latest_reply.discussion')->orderBy('order');
         }]);
   
         $sticky = $group->discussions()
                    ->sticky()
                    ->withCount('replies')
                    ->get();
   
         $normal = $group->discussions()
                    ->sticky(false)
                    ->withCount('replies')
                    ->paginate(config('rancor.forums.pagination'));
   
         return view('rancor::Groups.show',compact('category','Group','sticky','normal'));
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
        $groups = Group::orderBy('title')->get();
        $groups = Group::orderBy('name')->get();
        $categories = Category::orderBy('title')->get();
        $group->load('category','groups');

        return view('rancor::Groups.edit',compact('Group', 'groups','Groups','categories'));
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

        $group->groups()->sync($data['groups']);

        return redirect()->route('forums.groups.index')->with('alert', 'Group "'.$group->title.'" has been successfully updated');
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

        return redirect()->route('forums.groups.index')->with('alert', 'Group "'.$group->title.'" has been successfully deleted');
    }
}