<?php

namespace Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Models\Board;
use Rancor\Forums\Http\Requests\DiscussionSearch;
use Rancor\Forums\Http\Requests\EditDiscussionForm;
use Rancor\Forums\Http\Requests\NewDiscussionForm;

class DiscussionController extends Controller
{
	/**
	 * Variable used in View rendering
	 * 
	 * @var array
	 */
	protected $resource = [
		'name' => 'Discussion',
		'route' => 'discussions'
	];
	
	/**
	 * Display a listing of the resource.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$this->authorize('viewAny',Discussion::class);

		$resource = $this->resource;
		$models = Discussion::paginate(config('rancor.pagination'));
		
		return view('rancor::resources.index', compact('resource','models'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return \Illuminate\Http\Response
	 */
	public function show(Discussion $discussion)
	{
		$this->authorize('view',$discussion);

		$discussion->load('board')->loadCount('replies');
  
		return view('rancor::show.discussion',compact('discussion'));
	}

	/**
	 * Display the resources that match the search query.
	 *
	 * @param  \Rancor\Forums\Http\Requests\DiscussionSearch  $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(DiscussionSearch $request)
	{
		$this->authorize('viewAny', Discussion::class);
		
		$resource = $this->resource;
		$search = $request->validated();
		$models = Discussion::where($search['attribute'], 'like', '%' . $search['value'] . '%')
				->paginate(config('rancor.pagination'));

		return view('rancor::resources.index', compact('models','resource'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if(!$request->has('board')) abort (422, 'Board ID needed to create a Discussion');

		$board = Board::with('category')->findOrFail($request->board);

		$this->authorize('create', [Discussion::class, $board]);

		return view('rancor::create.discussion',compact('board'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Forums\Http\Requests\NewDiscussionForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewDiscussionForm $request)
	{
		$data = $request->validated();
		$board = Board::with('category', 'moderators')->findOrFail($data['board_id']);
		$this->authorize('create', [Discussion::class, $board]);

		$discussion;
		
		DB::transaction(function () use(&$discussion, $data) {
			$discussion = Discussion::create($data);
			$discussion->replies()->create($data);
		});

		return redirect()->route('forums.discussion', [
			'category' => $board->category,
			'board' => $board,
			'discussion' => $discussion,
		],)->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $discussion->name,'action' => 'created']
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Discussion $discussion)
	{
		$this->authorize('update', $discussion);
		
		$resource = $this->resource;
		$form = $this->form();
		$model = $discussion;

		return view('rancor::resources.edit',compact('resource','form','model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Forums\Http\Requests\EditDiscussionForm  $request
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return \Illuminate\Http\Response
	 */
	public function update(EditDiscussionForm $request, Discussion $discussion)
	{
		$this->authorize('update',$discussion);
		
		$data = $request->validated();
		$discussion->update($data);

		return redirect()->route('admin.discussions.index')->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $discussion->name,'action' => 'updated']
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Forums\Models\Discussion  $discussion
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Discussion $discussion)
	{
		$this->authorize('delete',$discussion);
		
		$discussion->delete();

		return redirect()->route('admin.discussions.index')->with('alert', [
			'message' => ['model' => $this->resource['name'], 'name' => $discussion->name,'action' => 'deleted']
		]);
	}

	/**
	 * Variable for Form fields used in Create and Edit Views
	 * 
	 * @var array
	 */
	protected function form($board = null)
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
			'checkboxes' => [
				[
					'name' => 'is_sticky',
					'label' => 'Make Sticky'
				],
				[
					'name' => 'is_locked',
					'label' => 'Lock'
				],
			],
			'selects' => [
				[
					'name' => 'board_id',
					'label' => 'Board',
					'multiple' => false,
					'attributes' => 'required',
					'options' => Board::orderBy('name')->get()
				]
			]
		];
	}
}