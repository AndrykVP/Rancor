<x-rancor::main-layout>
	<x-slot name="header">
		<div class="flex flex-col md:flex-row justify-between">
			<ul class="flex text-sm lg:text-base">
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.index') }}">{{ __('Forums') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.category', $category) }}">{{ Str::limit($category->name, 15) }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.board', ['category' => $category, 'board' => $board]) }}">{{ Str::limit($board->name, 15) }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ Str::limit($discussion->name, 15) }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@can('update',$discussion)
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2" href="{{ route('admin.discussions.edit', $discussion) }}">{{ __('Edit Discussion') }}</a>
				@endcan
				@can('create', [\Rancor\Forums\Models\Reply::class, $discussion])
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('forums.replies.create', ['discussion' => $discussion]) }}">{{ __('New Reply') }}</a>
				@endcan
				@can('delete',$discussion)
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-red-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="#">{{ __('Delete Discussion') }}</a>
				@endcan
			</div>
		</div>
	</x-slot>
	@if($replies->total() >= config('rancor.pagination'))
	<div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
		{{ $replies->links() }}
	</div>
	@endif
	
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@forelse($replies as $reply)
			<div class="border bg-white w-full md:rounded overflow-hidden mb-5" id="{{ $reply->id }}">
				<div class="border-b bg-gray-200 text-xs">
					<div class="flex justify-between items-center px-4 py-2">
						<div class="col small">Posted {{ $reply->created_at->diffForHumans() }}@if($reply->editor != null). Last Edited by: {{ $reply->editor->name . ' '. $reply->updated_at->diffForHumans() }}@endif</div>
						<div class="col text-right">
							@can('create', [\Rancor\Forums\Models\Reply::class, $discussion])
							<a type="button" class="text-white bg-blue-600 px-2 py-1 rounded" href="{{ route('forums.replies.create',[ 'discussion' => $discussion, 'quote' => $reply ]) }}">Quote</a>
							@endcan
							@can('update', $reply)
							<a type="button" class="text-white bg-green-600 px-2 py-1 rounded" href="{{ route('forums.replies.edit',[ 'reply' => $reply ]) }}">Edit</a>
							@endcan
							@can('delete', $reply)
							<button type="button" class="text-white bg-red-600 px-2 py-1 rounded" href="#">Delete</button>
							@endcan
						</div>
					</div>
				</div>
				<div class="grid grid-cols-4">
					<div class="flex flex-col col-span-1 justify-start items-center border-r px-2 py-4">
						<img src="{{ $reply->author->avatar}}" width="150" height="150"/>
						<div class="my-2">
							@if($reply->author->rank != null)
							<span><a href="{{ route('profile.show', $reply->author) }}" class="font-bold md:text-lg text-indigo-900 hover:text-indigo-700">{{ $reply->author->name }}</a></span><br/>
							<span class="text-sm md:text-base" style="color: {{ $reply->author->rank->color }}">{{ $reply->author->rank->name }}</span><br>
							<span class="text-sm md:text-base" style="color: {{ $reply->author->rank->department->color }}">{{ $reply->author->rank->department->name }}</span><br>
							@else
							Guest
							@endif

							@if($board->moderators->contains(Auth::user()))
							Moderator<br/>
							@endif
							
							<span class="text-xs">Posts: {{ number_format($reply->author->replies_count) }}</span><br/>
						</div>
					</div>
					<div class="flex flex-col col-span-3">
						<div class="border-b h-3/4 px-4 py-2">
							{!!($reply->body) !!}
						</div>
						<div class="h-auto row-span-1 px-4 py-2">
							{!! $reply->author->signature !!}
						</div>
					</div>
				</div>
			</div>
			@empty
			<div class="border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
				<div class="p-4">
					No Replies by this User
				</div>
			</div>
			@endforelse
		</div>
	</div>
</x-rancor::main-layout>