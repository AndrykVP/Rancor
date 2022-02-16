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
				<li class="inline-flex items-center text-gray-500">
					{{ Str::plural($resource['name']) }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				<form class="mr-4" action="{{ route('admin.'.$resource['route'].'.search') }}" method="POST">
					@csrf
					<div class="relative text-gray-600">
						<input type="hidden" name="attribute" value="{{ old('attribute') ?? 'name' }}">
						<input type="search" name="value" placeholder="Search by name..." class="bg-white h-10 px-5 pr-10 rounded-full border-gray-300 text-sm focus:border-indigo-300 focus:outline-none" value="{{ old('value') ?? null }}">
						<button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
						<svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
							<path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
						</svg>
						</button>
					</div>
				</form>
				@if(Route::has('admin.'.$resource['route'].'.create'))
				<a href="{{ route('admin.'.$resource['route'].'.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New ' . $resource['name'])}} </a>
				@endif
			</div>
		</div>
	</x-slot>
	@if($models->total() >= config('rancor.pagination'))
	<div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
		{{ $models->links() }}
	</div>
	@endif
	
	<div class="flex flex-col">
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
								{{ __('Actions') }}
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@foreach($models as $model)
							<tr>
								<th scope="row">{{ $model->id }}</th>
								<td>{{ $model->name }}</td>
								<td class="py-2">
									@if(Route::has('admin.'.$resource['route'].'.show'))
									<a href="{{ route('admin.'.$resource['route'].'.show',$model) }}" class="bg-blue-600 hover:bg-blue-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('View') }}">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
											<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
										</svg>
									</a>
									@endif
									@if(Route::has('admin.'.$resource['route'].'.edit'))
									<a href="{{ route('admin.'.$resource['route'].'.edit',$model) }}" class="bg-green-600 hover:bg-green-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Edit') }}">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
										</svg>
									</a>
									@endif
									@if(Route::has('admin.'.$resource['route'].'.destroy'))
									<a href="{{ route('admin.'.$resource['route'].'.destroy',$model) }}" class="bg-red-600 hover:bg-red-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Delete') }}"
									onclick="event.preventDefault();
									document.getElementById('{{ 'delete-model-' . $model->id }}').submit();">
										<svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
											<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
										</svg>
									</a>
									@endif

									<form id="{{ 'delete-model-' . $model->id }}" action="{{ route('admin.'.$resource['route'].'.destroy',$model) }}" method="POST" style="display: none;">
										@method('DELETE')
										@csrf
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</x-rancor::admin-layout>