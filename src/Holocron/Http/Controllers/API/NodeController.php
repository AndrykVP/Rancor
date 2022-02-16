<?php

namespace Rancor\Holocron\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Holocron\Models\Node;
use Rancor\Holocron\Http\Resources\NodeResource;
use Rancor\Holocron\Http\Requests\EditNodeForm;
use Rancor\Holocron\Http\Requests\NewNodeForm;
use Rancor\Holocron\Http\Requests\NodeSearch;

class NodeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny', Node::class);
		$nodes = Node::paginate(config('rancor.pagination'));

		return NodeResource::collection($nodes);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Holocron\Http\Requests\NewNodeForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewNodeForm $request)
	{
		$this->authorize('create', Node::class);
		$data = $request->validated();
		$node;
		DB::transaction(function () use(&$node, $data) {
			$node = Node::create($data);
			if(array_key_exists('collections', $data))
			{
				$node->collections()->sync($data['collections']);
			}
		});

		return response()->json([
			'message' => 'Node "'.$node->name.'" has been created'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Holocron\Models\Node  $node
	 * @return \Illuminate\Http\Response
	 */
	public function show(Node $node)
	{
		$this->authorize('view',$node);
		$node->load('collections','author','editor');

		return new NodeResource($node);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Holocron\Http\Requests\EditNodeForm  $request
	 * @param  \Rancor\Holocron\Models\Node  $node
	 * @return \Illuminate\Http\Response
	 */
	public function update(EditNodeForm $request, Node $node)
	{
		$this->authorize('update', $node);
		$data = $request->validated();
		DB::transaction(function () use(&$node, $data) {
			$node->update($data);
			if(array_key_exists('collections', $data))
			{
				$node->collections()->sync($data['collections']);
			}
		});

		return response()->json([
			'message' => 'Node "'.$node->name.'" has been updated'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Holocron\Models\Node  $node
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Node $node)
	{
		$this->authorize('delete', $node);
		$node->delete();

		return response()->json([
			'message' => 'Node "'.$node->name.'" has been deleted'
		], 200);
	}

	/**
	 * Display the results that match the search query.
	 *
	 * @param  \Rancor\Holocron\Http\Requests\NodeSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(NodeSearch $request)
	{
		$this->authorize('viewAny',Node::class);
		$search = $request->validated();        
		$nodes = Node::where($search['attribute'], 'like', '%' . $search['value'] . '%')
					->paginate(config('rancor.pagination'));

		return NodeResource::collection($nodes);
	}
}
