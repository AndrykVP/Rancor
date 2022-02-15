<?php

namespace Rancor\Forums\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Http\Resources\BoardResource;
use Rancor\Forums\Http\Requests\BoardForm;
use Rancor\Forums\Http\Requests\BoardSearch;

class BoardController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::paginate(config('rancor.pagination'));

        return BoardResource::collection($boards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\BoardForm  $request
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
            if(array_key_exists('groups', $data))
            {
                $board->groups()->sync($data['groups']);
            }
        });

        return response()->json([
            'message' => 'Board "'.$board->name.'" has been created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        $this->authorize('view',$board);

        return new BoardResource($board->load('category', 'parent', 'children', 'moderators', 'latest_reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Rancor\Forums\Http\Requests\BoardForm  $request
     * @param  \Rancor\Forums\Models\Board  $board
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
            if(array_key_exists('groups', $data))
            {
                $board->groups()->sync($data['groups']);
            }
        });

        return response()->json([
            'message' => 'Board "'.$board->name.'" has been updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rancor\Forums\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete',$board);
        
        DB::transaction(function () use($board) {
            $board->groups()->detach();
            $board->delete();
        });

        return response()->json([
            'message' => 'Board "'.$board->name.'" has been deleted'
        ], 200);        
    }

    /**
     * Display the results that match the search query.
     *
     * @param  \Rancor\Forums\Http\Requests\BoardSearch  $request
     * @return \Illuminate\Http\Response
     */
    public function search(BoardSearch $request)
    {
        $this->authorize('viewAny',Board::class);
        $search = $request->validated();
        $boards = Board::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        return BoardResource::collection($boards);
    }
}