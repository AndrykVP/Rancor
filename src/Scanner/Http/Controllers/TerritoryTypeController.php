<?php

namespace Rancor\Scanner\Http\Controllers;

use App\Http\Controllers\Controller;
use Rancor\Scanner\Http\Requests\TerritoryTypeForm;
use Rancor\Scanner\Http\Requests\TerritoryTypeSearch;
use Rancor\Scanner\Models\TerritoryType;

class TerritoryTypeController extends Controller
{
	/**
	 * Variable used in View rendering
	 * 
	 * @var array
	 */
	protected $resource = [
		'name' => 'Territory Type',
		'route' => 'territorytypes'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->authorize('viewAny',TerritoryType::class);
		$resource = $this->resource;
		$models = TerritoryType::paginate(config('rancor.pagination'));

		return view('rancor::resources.index', compact('resource', 'models'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
	 * @return \Illuminate\Http\Response
	 */
	public function show(TerritoryType $territorytype)
	{
		$this->authorize('view', $territorytype);
		$territorytype->loadCount('territories');

		return view('rancor::show.territorytypes', compact('territorytype'));
	}

	/**
	 * Display the resources that match the search query.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\TerritoryTypeSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(TerritoryTypeSearch $request)
	{
		$this->authorize('viewAny', TerritoryType::class);
		
		$resource = $this->resource;
		$search = $request->validated();
		$models = TerritoryType::where($search['attribute'], 'like', $search['value'] . '%')
					->paginate(config('rancor.pagination'));

		session()->flashInput($request->input());
		return view('rancor::resources.index', compact('models', 'resource'));
	} 

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create',TerritoryType::class);
		$resource = $this->resource;
		$form = $this->form();

		return view('rancor::resources.create', compact('resource', 'form'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\TerritoryTypeForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TerritoryTypeForm $request)
	{
		$this->authorize('create',TerritoryType::class);
		$territorytype = TerritoryType::create($request->validated());

		return redirect(route('admin.territorytypes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'created']
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
	 * @return \Illuminate\Http\Response
	 */
	public function edit(TerritoryType $territorytype)
	{
		$this->authorize('update', $territorytype);
		$resource = $this->resource;
		$form = $this->form();
		$model = $territorytype;

		return view('rancor::resources.edit',compact('resource', 'form', 'model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\TerritoryTypeForm  $request
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
	 * @return \Illuminate\Http\Response
	 */
	public function update(TerritoryTypeForm $request, TerritoryType $territorytype)
	{
		$this->authorize('update', $territorytype);
		$territorytype->update($request->validated());

		return redirect(route('admin.territorytypes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'updated']
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Scanner\Models\TerritoryType  $territorytype
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(TerritoryType $territorytype)
	{
		$this->authorize('delete', $territorytype);
		$territorytype->delete();

		return redirect(route('admin.territorytypes.index'))->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $territorytype->name, 'action' => 'deleted']
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
					'name' => 'image',
					'label' => 'Image URL',
					'type' => 'url',
					'attributes' => 'required'
				],
			],
		];
	}
}
