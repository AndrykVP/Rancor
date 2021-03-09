<?php

namespace AndrykVP\Rancor\Scanner\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Scanner\Models\Entry;
use AndrykVP\Rancor\Scanner\Http\Resources\EntryResource;
use AndrykVP\Rancor\Scanner\Services\EntryParseService;
use AndrykVP\Rancor\Scanner\Http\Requests\SearchEntry;

class EntryController extends Controller
{
    /**
     * Construct Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware(config('rancor.middleware.api'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Entry::class);
        $records = Entry::paginate(15);

        return EntryResource::collection($records);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Entry::class);
        abort_if(!$request->hasFile('files'), 400, 'At least 1 XML file must be uploaded.');

        $scans = new EntryParseService($request);
        $scans->start();

        return response()->json([
            'updated' => $scans->updated,
            'new' => $scans->new,
            'unchanged' => $scans->unchanged,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $this->authorize('view', $entry);
        $entry->load('contributor','changelog');

        return new EntryResource($entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        $this->authorize('update', $entry);

        $contributor = $request->user();
        $new_data = $request->all();
        $entry->updated_by = $contributor->id;
        $entry->update($new_data);
        
        return response()->json([
            'message' => "Record for {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) has been updated.",
        ],200);
    }

    /**
     * Remove the specified Usergroup resource from storage.
     *
     * @param  \AndrykVP\Rancor\Scanner\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $this->authorize('delete', $entry);
        $entry->delete();

        return response()->json([
            'message' => "All records of the {$entry->type} \"{$entry->name}\" (#{$entry->entity_id}) have been successfully deleted."
        ],200);
    }

    /**
     * Search specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(SearchEntry $request)
    {
        $this->authorize('viewAny', Entry::class);
        $param = $request->validated();
        $query = Entry::where($param['attribute'],'like','%'.$param['value'].'%')->paginate(15);
        
        return EntryResource::collection($query);


    }
}
