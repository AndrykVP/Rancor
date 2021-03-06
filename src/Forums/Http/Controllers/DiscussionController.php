<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Models\Discussion;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Http\Requests\NewDiscussionForm;
use AndrykVP\Rancor\Forums\Http\Requests\EditDiscussionForm;

class DiscussionController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Discussion',
        'route' => 'discussions'
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Discussion::class);

        $resource = $this->resource;
        $models = Discussion::paginate(config('rancor.pagination'));
        
        return view('rancor::resources.index', compact('resource','models'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        $this->authorize('view',$discussion);

        $discussion->load('board')->loadCount('replies');
  
        return view('rancor::show.discussion',compact('discussion'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Discussion::class);
        
        $resource = $this->resource;
        $models = Discussion::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has('board')) abort (400, 'Board ID needed to create a Discussion');

        $board = Board::with('category')->findOrFail($request->board);

        $this->authorize('post', $board);

        return view('rancor::create.discussion',compact('board'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\NewDiscussionForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewDiscussionForm $request)
    {
        $this->authorize('create', Discussion::class);

        $data = $request->validated();
        $discussion;
        
        DB::transaction(function () use(&$discussion, $data) {
            $discussion = Discussion::create($data);
            $discussion->replies()->create($data);
        });

        $discussion->load('board.category');

        return redirect()->route('forums.discussion', [
            'category' => $discussion->board->category,
            'board' => $discussion->board,
            'discussion' => $discussion,
        ],)->with('alert', ['model' => $resource->name, 'name' => $discussion->name,'action' => 'created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function edit(Discussion $discussion)
    {
        $this->authorize('update', $discussion);
        
        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH'], $this->form());
        $model = $discussion;

        return view('rancor::resources.edit',compact('resource','form','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\EditDiscussionForm  $request
     * @param  \AndrykVP\Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(EditDiscussionForm $request, Discussion $discussion)
    {
        $this->authorize('update',$discussion);
        
        $data = $request->validated();
        $discussion->update($data);

        return redirect()->route('admin.discussions.index')->with('alert', ['model' => $resource->name, 'name' => $discussion->name,'action' => 'updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussion $discussion)
    {
        $this->authorize('delete',$discussion);
        
        $discussion->delete();

        return redirect()->route('admin.discussions.index')->with('alert', ['model' => $resource->name, 'name' => $discussion->name,'action' => 'deleted']);
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
            'checkboxes' => [
                [
                    'name' => 'is_sticky',
                    'label' => 'Make Sticky'
                ],
                [
                    'name' => 'is_locked',
                    'label' => 'Lock'
                ],
            ],
            'selects' => [
                [
                    'name' => 'board_id',
                    'label' => 'Board',
                    'multiple' => false,
                    'attributes' => 'required',
                    'options' => Board::orderBy('name')->get()
                ]
            ]
        ];
    }
}