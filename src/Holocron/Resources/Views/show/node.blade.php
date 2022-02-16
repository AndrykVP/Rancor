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
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.nodes.index') }}">{{ __('Nodes') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ $node->name }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@if(Route::has('admin.nodes.create'))
				<a href="{{ route('admin.nodes.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New Node')}}</a>
				@endif
				@if(Route::has('admin.nodes.edit'))
				<a href="{{ route('admin.nodes.edit', $node) }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2">{{ __('Edit Node')}}</a>
				@endif
			</div>
		</div>
	</x-slot>

	<div class="flex justify-center">
		<div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
				<div class="col-span-3">{{ $node->id }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Name:</div>
				<div class="col-span-3">{{ $node->name }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Status:</div>
				<div class="col-span-3 {{ $node->is_public ? 'text-green-700' : 'text-red-700' }}">{{ $node->is_public ? 'Public' : 'Private' }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Author:</div>
				<div class="col-span-3">{{ $node->author->name }}</div>
			</div>
			@if($node->editor != null)
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Editor:</div>
				<div class="col-span-3">{{ $node->editor->name }}</div>
			</div>
			@endif
			@if($node->collections->isNotEmpty())
			<div class="grid grid-cols-4 mb-2 gap-4 items-start">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Collections:</div>
				<div class="col-span-3">
					@foreach($node->collections as $collection)
					<span class="rounded bg-gray-200 px-2 py-1 text-xs font-bold mx-2">{{ $collection->name }}</span>
					@endforeach
				</div>
			</div>
			@endif
		</div>
	</div>
</x-rancor::admin-layout>