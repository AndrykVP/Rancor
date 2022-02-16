<x-rancor::admin-layout>
	<x-slot name="header">
		<div class="flex flex-col md:flex-row justify-between">
			<ul class="flex text-sm lg:text-base">
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.boards.index') }}">{{ __('Boards') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ $board->name }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@if(Route::has('admin.boards.create'))
				<a href="{{ route('admin.boards.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New Board')}}</a>
				@endif
				@if(Route::has('admin.boards.edit'))
				<a href="{{ route('admin.boards.edit', $board) }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2">{{ __('Edit Board')}}</a>
				@endif
			</div>
		</div>
	</x-slot>

	<div class="flex justify-center">
		<div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
				<div class="col-span-3">{{ $board->id }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Name:</div>
				<div class="col-span-3">{{ $board->name }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">URL:</div>
				<div class="col-span-3">{{ $board->slug }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Description:</div>
				<div class="col-span-3">{{ $board->description }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Category:</div>
				<div class="col-span-3">{{ $board->category->name }}</div>
			</div>
			@if($board->parent != null)
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Parent Board:</div>
				<div class="col-span-3">{{ $board->parent->name }}</div>
			</div>
			@endif
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Total Discussions:</div>
				<div class="col-span-3">{{ number_format($board->discussions_count) }}</div>
			</div>
			@if($board->children->isNotEmpty())
			<div class="grid grid-cols-4 mb-2 gap-4 items-start">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Children Boards:</div>
				<div class="col-span-3">
					<ul>
						@foreach($board->children as $child)
						<li>{{ $child->name }}</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
			@if($board->groups->isNotEmpty())
			<div class="grid grid-cols-4 mb-2 gap-4 items-start">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Groups:</div>
				<div class="col-span-3">
					<ul>
						@foreach($board->groups as $group)
						<li>{{ $group->name }}</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
			@if($board->moderators->isNotEmpty())
			<div class="grid grid-cols-4 mb-2 gap-4 items-start">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Moderators:</div>
				<div class="col-span-3">
					<ul>
						@foreach($board->moderators as $moderator)
						<li>{{ $moderator->name }}</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
		</div>
	</div>
</x-rancor::admin-layout>