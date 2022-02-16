<x-rancor::main-layout>
	<x-slot name="header">
		<ul class="flex text-sm lg:text-base">
			<li class="inline-flex items-center text-indigo-800">
				<a href="{{ route('holocron.index') }}">Holocron</a>
				<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
				</svg>
			</li>
			<li class="inline-flex items-center text-indigo-800">
				<a href="{{ route('holocron.node.index') }}">Nodes</a>
				<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
				</svg>
			</li>
			<li class="inline-flex items-center text-gray-500">
				{{ $node->name }}
			</li>
		 </ul>
	</x-slot>
 
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
				<div class="p-4">
					<div class="flex justify-between">
						<h1 class="text-xl font-bold">{{ $node->name }}</h1>
						@can('update', $node)
						<a href="{{ route('admin.articles.edit',$node) }}" class="bg-green-700 hover:bg-green-600 text-gray-200 py-2 px-2 rounded inline-flex items-center transition ease-in-out duration-300" title="{{ __('Edit') }}">
							<svg class="fill-current w-4 h-4 mr-2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
						</a>
						@endcan
					</div>
					<div class="font-bold text-gray-800 mb-2">
						@if($node->is_published)
						<small>Published {{ $node->published_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $node->author]) }}">{{ $node->author->name }}</a></small><br />
						@else
						<small>Created {{ $node->created_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $node->author]) }}">{{ $node->author->name }}</a></small><br />
						@endif
						@if($node->editor != null)
						<small>Last edited {{ $node->updated_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $node->editor]) }}">{{ $node->editor->name }}</a></small><br />
						@endif
					</div>
					<p class="text-gray-700 text-base mb-2">
						{!! $node->body !!}
					</p>
				</div>
				<div class="border-t p-4">
					@forelse($node->collections as $collection)
						<a href="{{ route('holocron.collection.show', $collection) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-900 mr-2 mb-2">
							#{{ $collection->name }}
						</a>
					@empty
					<span class="inline-block bg-red-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-900 mr-2 mb-2">
						No Collections
					</span>
					@endforelse
				</div>
			</div>
		</div>
	</div>
</x-rancor::main-layout>