<x-rancor::main-layout>
	<x-slot name="header">
		<div class="flex flex-col md:flex-row justify-between">
			<ul class="flex text-sm lg:text-base">
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('scanner.index') }}">{{ __('Scanner') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ $territory->name ? $territory->name : __('Deep Space') }} {{ ' (' . $territory->x_coordinate . ', ' . $territory->y_coordinate . ')' }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@can('create', \Rancor\Scanner\Models\Entry::class)
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('scanner.create') }}">{{ __('Upload XML Scan') }}</a>
				@endcan
			</div>
		</div>
	</x-slot>
	@if($entries->total() >= config('rancor.pagination'))
	<div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
		{{ $entries->links() }}
	</div>
	@endif

	<div class="w-full flex flex-col p-6">
		<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
				<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('ID') }}
								</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('Name') }}
								</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('Owner') }}
								</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('IFF') }}
								</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('Position') }}
								</th>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								{{ __('Actions') }}
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@forelse($entries as $entry)
							<tr>
								<th scope="row">{{ $entry->entity_id }}</th>
								<td>{{ $entry->name }}</td>
								<td>{{ $entry->owner }}</td>
								<td class="{{ $entry->alliance > 0 ? 'text-green-600' : ($entry->alliance < 0 ? 'text-red-600' : '') }}">{{ $entry->alliance_text }}</td>
								<td>
									@if($entry->position != null)
									Orbit: ({{ $entry->position['orbit']['x'] }}, {{ $entry->position['orbit']['y'] }})
									@if(array_key_exists('atmosphere', $entry->position))
										<br />Atmosphere : ({{ $entry->position['atmosphere']['x'] }}, {{ $entry->position['atmosphere']['y'] }})
										@if(array_key_exists('ground', $entry->position))
											<br />Gound: ({{ $entry->position['ground']['x'] }}, {{ $entry->position['ground']['y'] }})
										@endif
									@endif
									@else
									-
									@endif                           
								</td>
								<td class="py-2">
									@can('view', $entry)
									<a href="{{ route('admin.entries.show', $entry) }}" class="bg-blue-600 hover:bg-blue-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('View') }}">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
											<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
										</svg>
									</a>
									@endcan
									@can('edit', $entry)
									<a href="{{ route('admin.entries.edit',$entry) }}" class="bg-green-600 hover:bg-green-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Edit') }}">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
										</svg>
									</a>
									@endcan
									@can('delete', $entry)
									<a href="{{ route('admin.entries.destroy',$entry) }}" class="bg-red-600 hover:bg-red-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Delete') }}"
									onclick="event.preventDefault();
									document.getElementById('{{ 'delete-entry-' . $entry->id }}').submit();">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
										</svg>
									</a>
									@endcan

									<form id="{{ 'delete-entry-' . $entry->id }}" action="{{ route('admin.entries.destroy',$entry) }}" method="POST" style="display: none;">
										@method('DELETE')
										@csrf
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6" class="text-center p-4">No Entries Found</td>
							</tr>
							@endforelse
						</tbody>
						<tfoot class="bg-gray-50">
							<tr>
								<td colspan="6">
									<div class="flex justify-center py-2">
										<form class="inline-flex" action="{{ route('scanner.territories', $territory) }}" method="GET">
											<label for="filterNeutral" class="inline-flex mr-4 items-center">
												<input
												type="checkbox"
												class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
												name="neutral"
												id="filterNeutral"
												aria-describedby="filterNeutralHelp"
												{{ in_array(0, old('filter')) ? 'checked' : ''}}>
												<span class="ml-2 text-sm text-gray-600">Neutral</span>
											</label>
											<label for="filterFriend" class="inline-flex mr-4 items-center">
												<input
												type="checkbox"
												class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
												name="friend"
												id="filterFriend"
												aria-describedby="filterFriendHelp"
												{{ in_array(1, old('filter')) ? 'checked' : ''}}>
												<span class="ml-2 text-sm text-gray-600">Friend</span>
											</label>
											<label for="filterEnemy" class="inline-flex mr-4 items-center">
												<input
												type="checkbox"
												class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
												name="enemy"
												id="filterEnemy"
												aria-describedby="filterEnemyHelp"
												{{ in_array(-1, old('filter')) ? 'checked' : ''}}>
												<span class="ml-2 text-sm text-gray-600">Enemy</span>
											</label>
											<button type="submit" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
												{{ __('Apply Filter') }}
											</button>
										</form>
									</div>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</x-rancor::main-layout>