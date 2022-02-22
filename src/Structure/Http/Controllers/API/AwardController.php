<?php

namespace Rancor\Structure\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Rancor\Structure\Models\Award;
use Rancor\Structure\Http\Resources\AwardResource;
use Rancor\Structure\Http\Requests\AwardForm;
use Rancor\Structure\Http\Requests\AwardSearch;

class AwardController extends Controller
{    
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$query = Award::paginate(config('rancor.pagination'));

		return AwardResource::collection($query);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\AwardForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AwardForm $request)
	{
		$this->authorize('create',Award::class);
		
		$data = $request->validated();
		$award = Award::create($data);

		return response()->json([
			'message' => 'Award "'.$award->name.'" has been created'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Structure\Models\Award  $award
	 * @return \Illuminate\Http\Response
	 */
	public function show(Award $award)
	{
		$this->authorize('view', $award);
		$award->load('type','users');

		return new AwardResource($award);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Structure\Http\Requests\AwardForm  $request
	 * @param  \Rancor\Structure\Models\Award  $award
	 * @return \Illuminate\Http\Response
	 */
	public function update(AwardForm $request, Award $award)
	{
		$this->authorize('update', $award);
		
		$data = $request->validated();
		$award->update($data);

		return response()->json([
			'message' => 'Award "'.$award->name.'" has been updated'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Structure\Models\Award  $award
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Award $award)
	{
		$this->authorize('delete', $award);
		$award->delete();

		return response()->json([
			'message' => 'Award "'.$award->name.'" has been deleted'
		], 200);        
	}

	/**
	 * Display the results that match the search query.
	 *
	 * @param  \Rancor\Structure\Http\Requests\AwardSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(AwardSearch $request)
	{
		$this->authorize('viewAny',Award::class);
		$search = $request->validated();
		$awards = Award::where($search['attribute'], 'like', '%' . $search['value'] . '%')
					->paginate(config('rancor.pagination'));

		return AwardResource::collection($awards);
	}
}