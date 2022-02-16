<?php

namespace Rancor\Scanner\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Rancor\Scanner\Models\Entry;
use Rancor\Scanner\Http\Resources\EntryResource;
use Rancor\Scanner\Http\Requests\EntryForm;
use Rancor\Scanner\Http\Requests\EntrySearch;

class EntryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny',Entry::class);
		$entries = Entry::paginate(config('rancor.pagination'));

		return EntryResource::collection($entries);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\EntryForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(EntryForm $request)
	{
		$this->authorize('create',Entry::class);
		$entry = Entry::create($request->validated());

		return response()->json([
			'message' => "Record for {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) has been created",
		],200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Scanner\Models\Entry  $entry
	 * @return \Illuminate\Http\Response
	 */
	public function show(Entry $entry)
	{
		$this->authorize('view', $entry);
		$entry->load('territory', 'contributor', 'changelog');

		return new EntryResource($entry);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\EditEntry  $request
	 * @param  \Rancor\Scanner\Models\Entry  $entry
	 * @return \Illuminate\Http\Response
	 */
	public function update(EntryForm $request, Entry $entry)
	{
		$this->authorize('update', $entry);
		$entry->update($request->validated());
		
		return response()->json([
			'message' => "Record for {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) has been updated",
		],200);
	}

	/**
	 * Remove the specified Usergroup resource from storage.
	 *
	 * @param  \Rancor\Scanner\Models\Entry  $entry
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Entry $entry)
	{
		$this->authorize('delete', $entry);
		$entry->delete();

		return response()->json([
			'message' => "All records of {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) have been deleted"
		],200);
	}

	/**
	 * Search specified resource.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\EntrySearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(EntrySearch $request)
	{
		$this->authorize('viewAny', Entry::class);
		$param = $request->validated();
		$query = Entry::where($param['attribute'],'like','%'.$param['value'].'%')->paginate(config('rancor.pagination'));
		
		return EntryResource::collection($query);
	}
}
