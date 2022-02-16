<?php

namespace Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Rancor\Scanner\Models\Entry;
use Rancor\Scanner\Models\Quadrant;
use Rancor\Scanner\Models\Territory;
use Rancor\Scanner\Models\TerritoryType;
use Rancor\Scanner\Http\Requests\UploadScan;
use Rancor\Scanner\Http\Requests\TerritoryFilter;
use Rancor\Scanner\Http\Requests\TerritoryForm;
use Rancor\Scanner\Services\EntryParseService;

class ScannerController extends Controller
{

	/**
	 * Display the resource specified in the rancor configuration.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$quadrant = Quadrant::findOrFail(config('rancor.scanner.index'));
		
		return $this->quadrant($quadrant);
	}

	/**
	 * Display the resource specified in the rancor configuration.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(Request $request)
	{
		$coordinates = $request->validate(['coordinates' => 'required|string'])['coordinates'];
		$coordinates = preg_replace('/\(|\)\s+/', '', $coordinates);
		$coordinates = explode(',', $coordinates);
		
		$quadrant = Quadrant::whereHas('territories', function(Builder $query) use($coordinates) {
			$query->where([
				['x_coordinate', $coordinates[0]],
				['y_coordinate', $coordinates[1]],
			]);
		})->firstOrFail();
		
		session()->flashInput($request->input());
		return $this->quadrant($quadrant);
	}
	
	/**
	 * Display the specified quadrant.
	 *
	 * @param  \Rancor\Scanner\Models\Quadrant  $quadrant
	 * @return \Illuminate\Http\Response
	 */
	public function quadrant(Quadrant $quadrant)
	{
		$this->authorize('view', $quadrant);

		$quadrant->load('territories.type', 'territories.patroller');
		$types = TerritoryType::all();

		return view('rancor::scanner.quadrant', compact('quadrant', 'types'));
	}

	/**
	 * Display the specified territory.
	 *
	 * @param \Rancor\Scanner\Http\Requests\TerritoryFilter  $request
	 * @param  \Rancor\Scanner\Models\Territory  $territory
	 * @return \Illuminate\Http\Response
	 */
	public function territory(TerritoryFilter $request, Territory $territory)
	{
		$this->authorize('view', $territory);

		$data = $request->validated();

		$entries = Entry::where('territory_id', $territory->id)
				->whereIn('alliance', $data['filter'])
				->paginate(config('rancor.pagination'))
				->withQueryString();

		session()->flashInput($request->input());

		return view('rancor::scanner.territory', compact('territory', 'entries'));
	}


	/**
	 * Update the specified territory in storage.
	 *
	 * @param  \Rancor\Scanner\Http\Requests\TerritoryForm  $request
	 * @param  \Rancor\Scanner\Models\Territory  $territory
	 * @return \Illuminate\Http\Response
	 */
	public function update(TerritoryForm $request, Territory $territory)
	{
		$this->authorize('update', $territory);
		$action = '';
		if($request->has('delete'))
		{
			$territory->update([
				'name' => null,
				'type_id' => null,
				'patrolled_by' => null,
				'last_patrol' => null,
				'subscription' => false,
			]);
			$action = 'reset';
		}
		else
		{
			$territory->update($request->validated());
			$action = 'updated';
		}

		return back()->with('alert', [
			'message' => "Territory ({$territory->x_coordinate}, {$territory->y_coordinate}) has been {$action}"
		]);
	}

	/**
	 * Displays the upload form
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Entry::class);

		return view('rancor::scanner.create');
	}

	/**
	 * Stores the information from uploaded XML file
	 * 
	 * @param  \Rancor\Scanner\Http\Requests\UploadScan  $request
	 * @param  \Rancor\Scanner\Services\EntryParseService  $sevice
	 * @return \Illuminate\Http\Response
	 */
	public function store(UploadScan $request, EntryParseService $service)
	{
		$this->authorize('create', Entry::class);

		$service($request->validated(), $request->user());

		return redirect(route('scanner.create'))->with('alert', [
			'message' => $service->message(),
			'timeout' => 15000
		]);
	}
}
