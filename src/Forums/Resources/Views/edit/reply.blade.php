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
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.category', $reply->discussion->board->category) }}">{{ $reply->discussion->board->category->name }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.board', ['category' => $reply->discussion->board->category, 'board' => $reply->discussion->board]) }}">{{ $reply->discussion->board->name }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $reply->discussion->board->category, 'board' => $reply->discussion->board, 'discussion' => $reply->discussion]) }}">{{ $reply->discussion->name }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ __('Edit Reply') }}
				</li>
			</ul>
		</div>
	</x-slot>


	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="border bg-white w-full md:rounded overflow-hidden px-6 py-4">
				<form action="{{ route('forums.replies.update', ['reply' => $reply]) }}" method="POST">
					@method('PATCH')
					@csrf
					<input type="hidden" name="discussion_id" value="{{ $reply->discussion_id }}">
					<div class="mb-6">
						<label for="body" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
							{{ __('Content') }}
						</label>
						<textarea
						class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
						name="body"
						id="body"
						aria-describedby="bodyHelp"
						placeholder="Enter your Reply"
						required rows=7>{!! old('body') ?: $reply->body !!}</textarea>
					</div>
					<button type="submit" class="ml-3">{{ __('Post') }}</button>
				</form>
			</div>
		</div>
	</div>
</x-rancor::main-layout>