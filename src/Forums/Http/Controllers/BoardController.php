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
        
        return view('rancor::boards.index',['boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create',Board::class);
        $category = Category::find($request->category);
        $boards = Board::orderBy('title')->get();
        $groups = Group::all();
        $categories = Category::all();

        return view('rancor::boards.create',['groups' => $groups,'boards' => $boards,'categories' => $categories, 'selCategory' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\Forums\Http\Requests\BoardForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Board::class);
        
        $data = $request->validated();
        $board = Board::create($data);

        $board->groups()->sync($data['groups']);

        return redirect()->route('forums.boards.index')->with('success', 'Board "'.$board->title.'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        $this->authorize('view',$board);

        return view('rancor::boards.show',['board' => $board->load('category','groups')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AndrykVP\Rancor\Forums\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board, Request $request)
    {
        $this->authorize('update', $board);
        $boards = Board::all();
        $groups = Group::all();
        $categories = Category::all();

        return view('rancor::boards.edit',['board' => $board->load('category','groups'), 'groups' => $groups,'boards' => $boards,'categories' => $categories]);
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

        return redirect()->route('forums.boards.index')->with('success', 'Board "'.$board->title.'" has been successfully updated');
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

        return redirect()->route('forums.boards.index')->with('success', 'Board "'.$board->title.'" has been successfully deleted');
    }
}