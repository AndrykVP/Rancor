<x-rancor::main-layout>
	<x-slot name="header">
		<div class="flex flex-col md:flex-row justify-between">
			<ul class="flex text-sm lg:text-base">
				<li class="inline-flex items-center">
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ $user->name }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@if(Auth::id() === $user->id && $user->can('update', $user))
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2" href="{{ route('profile.edit', $user) }}">{{ __('Update Profile') }}</a>
				@endif
				@can('viewReplies', $user)
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2" href="{{ route('profile.replies', $user) }}">{{ __('View Forum Replies') }}</a>
				@endcan
			</div>
		</div>
	</x-slot>
	
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="grid md:grid-cols-2 gap-4">
				<div class="bg-white rounded border">
					<div class="w-full bg-gray-200 text-sm text-gray-500 font-bold tracking-wider uppercase px-4 py-2">{{ __('Identity') }}</div>
					<div class="flex flex-col px-4 py-2">
						@if($user->avatar != null)
						<div class="grid grid-cols-4 gap-4 items-end mb-2">
							<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Avatar') }}:</div>
							<div class="col-span-3"><img src="{{ $user->avatar }}" /></div>
						</div>
						@endif
						<div class="grid grid-cols-4 gap-4 items-center mb-2">
							<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Handle') }}:</div>
							<div class="col-span-3">{{ $user->name }}</div>
						</div>
						@if($user->nickname != null)
						<div class="grid grid-cols-4 gap-4 items-center mb-2">
							<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Nickname') }}:</div>
							<div class="col-span-3">{{ $user->nickname }}</div>
						</div>
						@endif
						@if($user->show_email)
						<div class="grid grid-cols-4 gap-4 items-center mb-2">
							<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Email') }}:</div>
							<div class="col-span-3">{{ $user->email }}</div>
						</div>
						@endif
						@if($user->quote != null)
						<div class="grid grid-cols-4 gap-4 items-center mb-2">
							<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Quote') }}:</div>
							<div class="col-span-3"><i>"{{ $user->quote }}"</i></div>
						</div>
						@endif
					</div>
				</div>

				<div class="grid grid-rows-3 gap-4">

					<div class="row-span-2 bg-white rounded border">
						<div class="w-full bg-gray-200 text-sm text-gray-500 font-bold tracking-wider uppercase px-4 py-2">{{ __('Service') }}</div>
						<div class="flex flex-col px-4 py-2">
							@if($user->rank != null)
							<div class="grid grid-cols-4 gap-4 items-end mb-2">
								<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Faction') }}:</div>
								<div class="col-span-3">{{ $user->rank->department->faction->name }}</div>
							</div>
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Department') }}:</div>
								<div class="col-span-3">{{ $user->rank->department->name }}</div>
							</div>
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Rank') }}:</div>
								<div class="col-span-3">{{ $user->rank->name }}</div>
							</div>
							@endif
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Joined') }}:</div>
								<div class="col-span-3">{{ $user->created_at->diffForHumans() }}</div>
							</div>
							@if($user->awards->isNotEmpty())
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-1 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Awards') }}:</div>
								<div class="col-span-3 inline-flex">
									@foreach($user->awards as $award)
										<img src="{{ asset('storge/awards/'.$award->code.'.png') }}" />
									@endforeach
								</div>
							</div>
							@endif
							@if($user->is_banned)
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-1 text-right text-red-600 text-xs uppercase font-medium tracking-wider">{{ __('Banned') }}:</div>
								<div class="col-span-3 inline-flex text-red-800">
									{{ $user->ban_reason }}
								</div>
							</div>
							@endif
						</div>
					</div>
	
					<div class="row-span-1 bg-white rounded border">
						<div class="w-full bg-gray-200 text-sm text-gray-500 font-bold tracking-wider uppercase px-4 py-2">{{ __('Forum Activity') }}</div>
						<div class="flex flex-col px-4 py-2">
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-2 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Started Discussions') }}:</div>
								<div class="col-span-2">{{ number_format($user->discussions_count) }}</div>
							</div>
							<div class="grid grid-cols-4 gap-4 items-center mb-2">
								<div class="col-span-2 text-right text-gray-600 text-xs uppercase font-medium tracking-wider">{{ __('Total Replies') }}:</div>
								<div class="col-span-2">{{ number_format($user->replies_count) }}</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</x-rancor::main-layout>