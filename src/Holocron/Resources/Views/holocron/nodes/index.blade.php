<x-rancor::main-layout>
	<x-slot name="header">
		<ul class="flex text-sm lg:text-base">
			<li class="inline-flex items-center text-indigo-800">
				<a href="{{ route('holocron.index') }}">Holocron</a>
				<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
				</svg>
			</li>
			<li class="inline-flex items-center text-gray-500">
				Nodes
			</li>
		 </ul>
	</x-slot>
 
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
				<div class="grid grid-cols-6 md:grid-cols-4 lg:grid-cols-3 gap-4 p-4">
					@forelse ($nodes as $letter => $nodes)
					<div class="mb-3">
						<h5 class="font-bold text-xl text-gray-700">{{ $letter }}</h5>
							@foreach ($nodes as $node)
								» <a href="{{ route('holocron.node.show', $node['id']) }}" class="text-indigo-700 hover:text-indigo-600">{{ $node['name'] }}</a><br />
							@endforeach
					</div>
					@empty
					No Nodes Found
					@endforelse
				</div>
			</div>
		</div>
	</div>
</x-rancor::main-layout>