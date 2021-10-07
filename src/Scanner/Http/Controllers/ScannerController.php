<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Models\Quadrant;
use AndrykVP\Rancor\Scanner\Models\Territory;
use AndrykVP\Rancor\Scanner\Models\TerritoryType;
use AndrykVP\Rancor\Scanner\Http\Requests\UploadScan;
use AndrykVP\Rancor\Scanner\Http\Requests\TerritoryForm;
use AndrykVP\Rancor\Scanner\Services\EntryParseService;

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
     * Display the specified quadrant.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\Quadrant  $quadrant
     * @return \Illuminate\Http\Response
     */
    public function quadrant(Quadrant $quadrant)
    {
        $this->authorize('view', $quadrant);

        $quadrant->load('territories.type');
        $types = TerritoryType::all();

        return view('rancor::scanner.quadrant', compact('quadrant', 'types'));
    }

    /**
     * Display the specified territory.
     *
     * @param  \AndrykVP\Rancor\Scanner\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function territory(Territory $territory)
    {
        $this->authorize('view', $territory);

        $entries = $territory->entries()->paginate(config('rancor.pagination'));

        return view('rancor::scanner.territory', compact('territory', 'entries'));
    }


    /**
     * Update the specified territory in storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\TerritoryForm  $request
     * @param  \AndrykVP\Rancor\Scanner\Models\Territory  $territory
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
     * @param  \AndrykVP\Rancor\Scanner\Http\Requests\UploadScan  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadScan $request)
    {
        $this->authorize('create', Entry::class);

        $scanner = new EntryParseService($request);
        $scanner->start();
        $response = 'Scanner Entries processed with: ';
        if($scanner->new > 0)
        {
            $response = $response." {$scanner->new} new.";
        }
        if($scanner->updated > 0)
        {
            $response = $response." {$scanner->updated} updated.";
        }
        if($scanner->unchanged > 0)
        {
            $response = $response." {$scanner->unchanged} unchanged.";
        }

        return redirect(route('scanner.create'))->with('alert', [
            'message' => $response,
            'timeout' => 15000
        ]);
    }
}
