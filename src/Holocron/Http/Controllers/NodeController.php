<?php

namespace Rancor\Holocron\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Holocron\Models\Node;
use Rancor\Holocron\Models\Collection;
use Rancor\Holocron\Http\Requests\NewNodeForm;
use Rancor\Holocron\Http\Requests\EditNodeForm;
use Rancor\Holocron\Http\Requests\NodeSearch;

class NodeController extends Controller
{
	/**
	 * Variable used in View rendering
	 * 
	 * @var array
	 */
	protected $resource = [
		'name' => 'Node',
		'route' => 'nodes'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny', Node::class);

		$resource = $this->resource;
		$models = Node::paginate(config('rancor.pagination'));

		return view('rancor::resources.index', compact('models','resource'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Node::class);

		$resource = $this->resource;
		$form = $this->form();
		return view('rancor::resources.create', compact('resource','form'));
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
		DB::transaction(function () use(&$node,$data) {
			$node = Node::create($data);
			if(array_key_exists('collections', $data))
			{
				$node->collections()->sync($data['collections']);
			}
		});

		return redirect(route('admin.nodes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $node->name,'action' => 'created']
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Holocron\Models\Node  $node
	 * @return \Illuminate\Http\Response
	 */
	public function show(Node $node)
	{
		$this->authorize('view', $node);

		$node->load('collections', 'author', 'editor');

		return view('rancor::show.node', compact('node'));
	}

	/**
	 * Display the resources that match the search query.
	 *
	 * @param  \Rancor\Holocron\Http\Requests\NodeSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(NodeSearch $request)
	{
		$this->authorize('viewAny', Node::class);
		
		$resource = $this->resource;
		$search = $request->validated();
		$models = Node::where($search['attribute'], 'like', '%' . $search['value'] . '%')
					->paginate(config('rancor.pagination'));

		return view('rancor::resources.index', compact('models','resource'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \Rancor\Holocron\Models\Node  $node
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Node $node)
	{
		$this->authorize('update', $node);

		$resource = $this->resource;
		$form = $this->form();
		$model = $node;
		return view('rancor::resources.edit', compact('resource','form','model'));
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
		DB::transaction(function () use(&$node,$data) {
			$node->update($data);
			if(array_key_exists('collections', $data))
			{
				$node->collections()->sync($data['collections']);
			}
		});

		return redirect(route('admin.nodes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $node->name,'action' => 'updated']
		]);
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

		return redirect(route('admin.nodes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $node->name,'action' => 'deleted']
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
			],
			'textareas' => [
				[
					'name' => 'body',
					'label' => 'Content',
					'type' => 'text',
					'attributes' => 'row="9"'
				],
			],
			'selects' => [
				[
					'name' => 'collections',
					'label' => 'Collections',
					'multiple' => true,
					'options' => Collection::orderBy('name')->get(),
				],
			],
			'checkboxes' => [
				[
					'name' => 'is_public',
					'label' => 'Make Public',
				],
			]
		];
	}
}
