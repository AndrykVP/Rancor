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
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.tags.index') }}">{{ __('Tags') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ $tag->name }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@if(Route::has('admin.tags.create'))
				<a href="{{ route('admin.tags.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New Tag')}}</a>
				@endif
				@if(Route::has('admin.tags.edit'))
				<a href="{{ route('admin.tags.edit', $tag) }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2">{{ __('Edit Tag')}}</a>
				@endif
			</div>
		</div>
	</x-slot>

	<div class="flex justify-center">
		<div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
				<div class="col-span-3">{{ $tag->id }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Name:</div>
				<div class="col-span-3">{{ $tag->name }}</div>
			</div>
			<div class="grid grid-cols-4 mb-2 gap-4 items-center">
				<div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Article Count:</div>
				<div class="col-span-3">{{ number_format($tag->articles_count) }}</div>
			</div>
		</div>
	</div>
</x-rancor::admin-layout>