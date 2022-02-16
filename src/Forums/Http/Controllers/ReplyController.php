<?php

namespace Rancor\Forums\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Rancor\Forums\Models\Reply;
use Rancor\Forums\Models\Discussion;
use Rancor\Forums\Http\Requests\NewReplyForm;
use Rancor\Forums\Http\Requests\EditReplyForm;

class ReplyController extends Controller
{
	/**
	 * Variable used in View rendering
	 * 
	 * @var array
	 */
	protected $resource = [
		'name' => 'Reply',
		'route' => 'replies'
	];
	
	/**
	 * Display a listing of the resource.
	 *
	 * @param \App\Models\User  $user
	 * @return \Illuminate\Http\Response
	 */
	public function index(User $user)
	{
		$this->authorize('viewReplies', $user);

		$replies = $user->replies()
					->with('discussion.board.category')
					->paginate(config('rancor.pagination'));

		return view('rancor::forums.replies', compact('replies', 'user'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		if(!$request->has('discussion')) abort (422, 'Discussion ID needed to create a Reply');

		$discussion = Discussion::with('board.category')->findOrFail($request->discussion);

		$this->authorize('create', [Reply::class, $discussion]);
		$quote = Reply::with('author')->find($request->quote);

		if($quote != null)
		{
			$quote = '<blockquote>'.clean($quote->body).'<footer>'.$quote->author->name.'</footer></blockquote>';
		}

		return view('rancor::create.reply', compact('discussion','quote'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Rancor\Forums\Http\Requests\NewReplyForm  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewReplyForm $request)
	{
		$data = $request->validated();
		$discussion = Discussion::with('board.moderators', 'board.category')->findOrFail($data['discussion_id']);
		$this->authorize('create', [Reply::class, $discussion]);
		
		$reply = Reply::create($data);
		
		$page = $discussion->pages;
		
		return redirect()->route('forums.discussion',[
			'category' => $discussion->board->category,
			'board' => $discussion->board,
			'discussion' => $discussion,
			'page' => $page
		])->with('alert', [
			'message' => ['model' => $this->resource['name'], 'id' => $reply->id, 'action' => 'created']
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Reply $reply)
	{
		$this->authorize('update', $reply);
		$reply->load('discussion.board.category');

		return view('rancor::edit.reply', compact('reply'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Rancor\Forums\Http\Requests\EditReplyForm  $request
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return \Illuminate\Http\Response
	 */
	public function update(EditReplyForm $request, Reply $reply)
	{
		$this->authorize('update',$reply);
		
		$data = $request->validated();
		$reply->update($data);
		$reply->load('discussion.board.category');
		
		$page = $reply->discussion()->withCount('replies')->pluck('replies_count')->first();
		$page = $page > 0 ? ceil($page / config('rancor.pagination')) : 1;
		
		return redirect()->route('forums.discussion',[
			'category' => $reply->discussion->board->category->slug,
			'board' => $reply->discussion->board->slug,
			'discussion' => $reply->discussion->id,
			'page' => $page
		])->with('alert', [
			'message' => ['model' => $this->resource['name'],  'id' => $reply->id, 'action' => 'updated']
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Rancor\Forums\Models\Reply  $reply
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Reply $reply)
	{
		$this->authorize('delete',$reply);
		
		$reply->delete();

		return redirect()->route('forums.discussion',[
			'category' => $reply->discussion->board->category->slug,
			'board' => $reply->discussion->board->slug,
			'discussion' => $reply->discussion->id,
		])->with('alert', [
			'message' => ['model' => $this->resource['name'], 'id' => $reply->id, 'action' => 'deleted']
		]);
	}

	/**
	 * Variable for Form fields used in Create and Edit Views
	 * 
	 * @var array
	 */
	protected function form($discussion)
	{
		return [
			'textareas' => [
				[
					'name' => 'body',
					'label' => 'Content',
					'attributes' => 'required'   
				]
			],
			'hiddens' => [
				[
					'name' => 'discussion_id',
					'value' => $discussion,
				],
			]
		];
	}
}