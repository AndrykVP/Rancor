<tr>
	<td class="px-6 py-4 whitespace-nowrap">
		<div class="flex items-center">
			<a class="relative font-bold text-xl text-indigo-900 hover:text-indigo-700" href="{{ route('forums.board', ['category' => $board->category, 'board' => $board]) }}">
				{{ $board->name }}
				@if($unread_replies > 0)
				<span class="absolute items-center justify-center px-2 py-1 -ml-3 -mt-3 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ number_format($unread_replies) }}</span>
				@endif
			</a><span class="text-xs text-gray-700 ml-4">({{ number_format($board->discussions_count) }} {{ __('Topics') }}. {{ number_format($board->replies_count) }} {{ __('Replies') }})</span>
		</div>
		<div>
			<span class="text-gray-600">{{ $board->description }}</span>
		</div>
		@if(count($board->children) > 0)
		<div>
			<span class="text-xs text-gray-500 uppercase tracking-wider">Child Boards:</span>
			@foreach ($board->children as $child)
			» <a href="{{ route('forums.board', ['category' => $category, 'board' => $child]) }}">{{ $child->name}}</a>
			@endforeach
		</div>
		@endif
		@if(count($board->moderators) > 0)
		<div>
			<span class="text-xs text-gray-500 uppercase tracking-wider">Moderators:</span>
			@foreach ($board->moderators as $moderator)
			» <a href="{{ route('profile.show', $moderator->id) }}">{{ $moderator->name}}</a>
			@endforeach
		</div>
		@endif
	</td>
	<td class="col-span-3 text-sm">
		@if($board->replies_count > 0)
		<strong>In:</strong> <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $board->category, 'board' => $board, 'discussion' => $board->latest_reply->discussion, 'page' => $board->latest_reply->page->number]).'#'.$board->latest_reply->page->index }}">{{ $board->latest_reply->discussion->name}}</a><br/>
		{{ $board->latest_reply->created_at->diffForHumans() }} by <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.show', $board->latest_reply->author) }}">{{ $board->latest_reply->author->name }}</a>
		@else
		No Posts Yet
		@endif
	</td>
</tr>