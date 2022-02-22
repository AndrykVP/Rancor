<?php

namespace Rancor\Structure\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Structure\Models\Rank;
use Rancor\Structure\Http\Resources\RankResource;
use Rancor\Structure\Http\Requests\RankForm;
use Rancor\Structure\Http\Requests\RankSearch;

class RankController extends Controller
{    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = Rank::paginate(config('rancor.pagination'));

		return RankResource::collection($query);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\RankForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(RankForm $request)
	{
		$this->authorize('create',Rank::class);
		
		$data = $request->validated();
		$rank = Rank::create($data);

		return response()->json([
			'message' => 'Rank "'.$rank->name.'" has been created'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Rank $rank)
	{
		$this->authorize('view', $rank);

		return new RankResource($rank->load('department.faction'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\RankForm  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(RankForm $request, Rank $rank)
	{
		$this->authorize('update',$rank);
		
		$data = $request->validated();
		$rank->update($data);

		return response()->json([
			'message' => 'Rank "'.$rank->name.'" has been updated'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Rank $rank)
	{
		$this->authorize('delete', $rank);
		
		$rank->delete();

		return response()->json([
			'message' => 'Rank "'.$rank->name.'" has been deleted'
		], 200);        
	}

	/**
	 * Display the results that match the search query.
	 *
	 * @param  \Rancor\Structure\Http\Requests\RankSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(RankSearch $request)
	{
		$this->authorize('viewAny',Rank::class);
		$search = $request->validated();
		$ranks = Rank::where($search['attribute'], 'like', '%' . $search['value'] . '%')
					->paginate(config('rancor.pagination'));

		return RankResource::collection($ranks);
	}
}