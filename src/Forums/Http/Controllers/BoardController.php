<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Models\Board;
use AndrykVP\Rancor\Forums\Models\Group;
use AndrykVP\Rancor\Forums\Models\Category;
use AndrykVP\Rancor\Forums\Http\Requests\BoardForm;

class BoardController extends Controller
{
    /**
     * Variable used in View rendering
     * 
     * @var array
     */
    protected $resource = [
        'name' => 'Board',
        'route' => 'boards'
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Board::class);
        
        $resource = $this->resource;
        $models = Board::paginate(config('rancor.pagination'));
        
        return view('rancor::resources.index',compact('models','resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Board::class);

        $resource = $this->resource;
        $form = array_merge(['method' => 'POST'], $this->form($request->category, $request->board));
        $params = $request->all();

        return view('rancor::resources.create',compact('resource','form','params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\BoardForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoardForm $request)
    {
        $this->authorize('create',Board::class);

        $data = $request->validated();
        if($request->has('parent_id'))
        {
            $parent = Board::find($data['parent_id']);
            $data['category_id'] = $parent->category_id;
        }
        $board;
        DB::transaction(function () use(&$board, $data) {
            $board = Board::create($data);
            $board->groups()->sync($data['groups']);
        });

        return redirect()->route('admin.boards.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $board->name,'action' => 'created']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Board $board)
    {
        $this->authorize('view',$board);

        $board->load('category','moderators','children','parent')->loadCount('discussions');
   
        return view('rancor::show.board',compact('board'));
    }

    /**
     * Display the resources that match the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', Board::class);
        
        $resource = $this->resource;
        $models = Board::where('name','like','%'.$request->search.'%')->paginate(config('rancor.pagination'));

        return view('rancor::resources.index', compact('models','resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);

        $resource = $this->resource;
        $form = array_merge(['method' => 'PATCH'], $this->form());
        $model = $board->load('category');

        return view('rancor::resources.edit',compact('model', 'form','resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\BoardForm  $request
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(BoardForm $request, Board $board)
    {
        $this->authorize('update',$board);
        
        $data = $request->validated();
        if($request->has('parent_id'))
        {
            $parent = Board::find($data['parent_id']);
            $data['category_id'] = $parent->category_id;
        }
        DB::transaction(function () use(&$board, $data) {
            $board->update($data);
            $board->groups()->sync($data['groups']);
        });

        return redirect()->route('admin.boards.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $board->name,'action' => 'updated']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete',$board);
        
        $board->delete();

        return redirect()->route('admin.boards.index')->with('alert', [
            'message' => ['model' => $this->resource['name'], 'name' => $board->name,'action' => 'deleted']
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
                    'name' => 'slug',
                    'label' => 'URL',
                    'type' => 'text',
                    'attributes' => 'required'
                ],
                [
                    'name' => 'lineup',
                    'label' => 'Display Order',
                    'type' => 'number',
                    'attributes' => 'required'
                ],
            ],
            'textareas' => [
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'attributes' => 'required'   
                ]
            ],
            'selects' => [
                [
                    'name' => 'groups',
                    'label' => 'Groups',
                    'attributes' => 'multiple',
                    'multiple' => true,
                    'options' => Group::orderBy('name')->get(),
                ],
                [
                    'name' => 'category_id',
                    'label' => 'Category',
                    'multiple' => false,
                    'options' => Category::orderBy('name')->get(),
                ],
                [
                    'name' => 'parent_id',
                    'label' => 'Parent Board',
                    'multiple' => false,
                    'options' => Board::orderBy('name')->get(),
                ]
            ]
        ];
    }
}