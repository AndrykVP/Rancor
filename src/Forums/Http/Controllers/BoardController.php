<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Group;
use AndrykVP\Rancor\Forums\Category;
use AndrykVP\Rancor\Forums\Http\Requests\BoardForm;

class BoardController extends Controller
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
        $this->authorize('viewAny',Board::class);

        $boards = Board::with('category')->orderBy('category_id')->orderBy('order')->get();
        
        return view('rancor::boards.index',compact('boards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Board::class);
        $parentBoard = Board::find($request->board);
        $selCategory = $parentBoard ? $parentBoard->category : Category::find($request->category);
        $boards = Board::orderBy('title')->get();
        $groups = Group::orderBy('name')->get();
        $categories = Category::orderBy('title')->get();

        return view('rancor::boards.create',compact('groups','boards','categories','selCategory','parentBoard'));
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
        $board = Board::create($data);

        $board->groups()->sync($data['groups']);

        return redirect()->route('forums.boards.index')->with('alert', 'Board "'.$board->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Board $board)
    {
        $this->authorize('view',$board);

        $board->load('category','moderators')->load(['children' => function($query) {
            $query->withCount('discussions','replies','children')->with('latest_reply.discussion')->orderBy('order');
         }]);
   
         $sticky = $board->discussions()
                    ->sticky()
                    ->withCount('replies')
                    ->get();
   
         $normal = $board->discussions()
                    ->sticky(false)
                    ->withCount('replies')
                    ->paginate(config('rancor.forums.pagination'));
   
         return view('rancor::boards.show',compact('category','board','sticky','normal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        $this->authorize('update', $board);
        $boards = Board::orderBy('title')->get();
        $groups = Group::orderBy('name')->get();
        $categories = Category::orderBy('title')->get();
        $board->load('category','groups');

        return view('rancor::boards.edit',compact('board', 'groups','boards','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\BoardForm  $request
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(BoardForm $request, Board $board)
    {
        $this->authorize('update',$board);
        
        $data = $request->validated();
        $board->update($data);

        $board->groups()->sync($data['groups']);

        return redirect()->route('forums.boards.index')->with('alert', 'Board "'.$board->title.'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete',$board);
        
        $board->delete();

        return redirect()->route('forums.boards.index')->with('alert', 'Board "'.$board->title.'" has been successfully deleted');
    }
}