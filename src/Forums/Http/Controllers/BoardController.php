<?php

namespace AndrykVP\Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Forums\Board;
use AndrykVP\Rancor\Forums\Http\Resources\BoardResource;
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
        $this->middleware(config('rancor.middleware'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::all();

        return BoardResource::collection($boards);
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
        
        $data = $request->all();
        $board = Board::create($data);

        return response()->json([
            'message' => 'Board "'.$board->title.'" has been created'
        ], 200);
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

        return new BoardResource($board->load('category','parent','children','discussions','moderators','latest_reply'));
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
        
        $data = $request->all();
        $board->update($data);

        return response()->json([
            'message' => 'Board "'.$board->title.'" has been updated'
        ], 200);
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

        return response()->json([
            'message' => 'Board "'.$board->title.'" has been deleted'
        ], 200);        
    }
}