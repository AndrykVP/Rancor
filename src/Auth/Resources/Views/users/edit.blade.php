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
					<a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.users.index') }}">{{ __('Users') }}</a>
					<svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
					</svg>
				</li>
				<li class="inline-flex items-center text-gray-500">
					{{ __('Edit') }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				@if(Route::has('admin.users.create'))
				<a href="{{ route('admin.users.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New User')}} </a>
				@endif
			</div>
		</div>
	</x-slot>

	<div class="flex flex-col items-center justify-center">
		<div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
			
			@if ($errors->any())
			<div class="mb-4">
				<div class="font-medium text-red-600">
					{{ __('Whoops! Something went wrong.') }}
				</div>
				
				<ul class="mt-3 list-disc list-inside text-sm text-red-600">
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			
			<form action="{{ route('admin.users.update', $user)}}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PATCH')
				<input type="hidden" name="id" value="{{ $user->id }}">
				@can('update', $user)
				<div class="mb-6">
					<label for="first_name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('First Name') }}
					</label>
					<input
					type="text"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="first_name"
					id="first_name"
					placeholder="Edit the User's Handle"
					required autofocus
					value="{{ old('first_name') ?: $user->first_name }}" />
				</div>
				<div class="mb-6">
					<label for="last_name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Last Name') }}
					</label>
					<input
					type="text"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="last_name"
					id="last_name"
					placeholder="Edit the User's Handle"
					required autofocus
					value="{{ old('last_name') ?: $user->last_name }}" />
				</div>
				<div class="mb-6">
					<label for="nickname" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Nickname') }}
					</label>
					<input
					type="text"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="nickname"
					id="nickname"
					placeholder="Edit the User's Nickname"
					value="{{ old('nickname') ?: $user->nickname }}" />
				</div>
				<div class="mb-6">
					<label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('E-mail') }}
					</label>
					<input
					type="email"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="email"
					id="email"
					placeholder="Edit the User's E-mail"
					required
					value="{{ old('email') ?: $user->email }}" />
				</div>
				<div class="mb-6">
					<label for="quote" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Quote') }}
					</label>
					<input
					type="text"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="quote"
					id="quote"
					placeholder="Edit the User's Quote"
					value="{{ old('quote') ?: $user->quote }}" />
				</div>
				<div class="mb-6">
					<label for="avatar" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Avatar URL') }}
					</label>
					<input
					type="url"
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="avatar"
					id="avatar"
					placeholder="Edit the User's Avatar URL"
					value="{{ old('avatar') ?: $user->avatar }}" />
				</div>
				<div class="mb-6">
					<label for="signature" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Forum Signature') }}
					</label>
					<textarea
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="signature"
					id="signature"
					placeholder="Edit the User's Forum Signature">{{ old('signature') ?: $user->signature }}</textarea>
				</div>
				@endcan
				@can('changeRank', $user)
				<div x-data='changeRank()'>
					<div class="mb-6">
						<label for="faction" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
							{{ __('Faction') }}
						</label>
						<select
						class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
						name="faction"
						id="faction"
						x-model="selectedFaction"
						@change="selectedDepartment = null"
						aria-describedby="factionHelp"
						placeholder="Select a Faction">
							<option value="" :selected="selectedFaction == null" class="text-gray-500">Select a Faction</option>
							<template x-for="faction in factions" :key="faction.id">
								<option :value="faction.id" x-text="faction.name" :selected="faction.id == selectedFaction"></option>
							</template>
						</select>
					</div>
					<div class="mb-6" x-show.transition="selectedFaction != null">
						<label for="department" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
							{{ __('Department') }}
						</label>
						<select
						class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
						name="department"
						id="department"
						x-model="selectedDepartment"
						@change="selectedRank = null"
						aria-describedby="departmentHelp"
						placeholder="Select a Department">
							<template x-for="department in filteredDepartments" :key="department.id">
								<option :value="department.id" x-text="department.name" :selected="department.id == selectedDepartment"></option>
							</template>
						</select>
					</div>
					<div class="mb-6" x-show.transition="selectedDepartment != null">
						<label for="rank" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
							{{ __('Rank') }}
						</label>
						<select
						class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
						name="rank_id"
						id="rank"
						x-model="selectedRank"
						aria-describedby="rankHelp"
						placeholder="Select a Rank">
							<template x-for="rank in filteredRanks" :key="rank.id">
								<option :value="rank.id" x-text="rank.name" :selected="rank.id == selectedRank"></option>
							</template>
						</select>
					</div>
				</div>
				@endcan
				@can('uploadArt', $user)
				<div class="mb-6">
					<label for="avatarFile" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Avatar File') }}
					</label>
					<input
					type="file"
					accept="image/png" 
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="avatarFile"
					id="avatarFile"
					placeholder="Upload User's Avatar File">
				</div>
				<div class="mb-6">
					<label for="signatureFile" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _('Signature File') }}
					</label>
					<input
					type="file"
					accept="image/png" 
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="signatureFile"
					id="signatureFile"
					placeholder="Upload User's Signature File">
				</div>
				@endcan
				@can('changeRoles', $user)
				<div class="mb-6">
					<label for="roles" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ __('Roles') }}
					</label>
					<select
					class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="roles[]"
					id="roles"
					aria-describedby="rolesHelp"
					placeholder="Select a Role"
					multiple>
						@foreach($roles as $option)
						<option value="{{ $option->id }}" {{ $user->roles->contains('id', $option->id) ? 'selected' : ''}}>
							{{ $option->name}}
						</option>
						@endforeach
					</select>
				</div>
				@endcan
				@can('changeAwards', $user)
				<div class="mb-6">
					<label for="awards" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ __('Awards') }}
					</label>
					@foreach($award_types as $type)
					<div class="mb-6" id="type_{{ $type->id }}">
						<span class="uppercase text-xs font-bold">{{ $type->name }}</span>
						@foreach($type->awards as $award)
						@php
						$user_award = $user->awards->firstWhere("id", $award->id)
						@endphp
						<div x-data='{award: @json($award), checked: {{ $user_award != null ? "true" : "false" }}, level: {{ $user_award != null ? $user_award->pivot->level : 1 }} }' class="flex flex-row content-center mb-1">
							<input type="hidden" name="awards[{{ $award->id }}]" :value='checked ? level : 0'>
							<div class="flex flex-row flex-grow wrap-none items-center py-2">
								<input class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="checkbox" id="award_{{ $award->code }}_check" :checked="checked" x-model="checked"/>
								<span class="ml-4 text-sm text-gray-900 dark:text-gray-200" for="award_{{ $award->code }}" x-text="award.name"></span>
							</div>
							<template x-if="checked">
								<input class="w-20 md:w-28 text-sm px-2 py-1 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" type="number" id="award_{{ $award->code }}" x-model="level" min="1" :max="award.levels" />
							</template>
						</div>
						@endforeach
					</div>
					@endforeach
				</div>
				@endcan
				<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
					{{ __('Apply Changes') }}
			  </button>
			</form>

		</div>

		@can('ban', $user)
		<div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
			<form action="{{ route('admin.users.ban', $user)}}" method="POST">
				@csrf
				@method('PATCH')
				<input type="hidden" name="status" value="{{ !$user->is_banned }}">
				<div class="mb-6">
					<label for="reason" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
						{{ _($user->is_banned ? 'Unban' : 'Ban' .' Reason') }}
					</label>
					<textarea
					class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
					name="reason"
					id="reason"
					placeholder="{{ 'Reason to ' . ($user->is_banned ? 'Unban ' : 'Ban ' . $user->name) }}">{{ old('reason') ?: '' }}</textarea>
				</div>
				<button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
					{{ __($user->is_banned ? 'Unban' : 'Ban') }}
				</button>
			</form>
		</div>
		@endcan
	</div>

	<script lang="text/js">
	function changeRank() {
		return {
			factions: @json($factions),
			departments: @json($departments),
			ranks: @json($ranks),
			selectedFaction: @json($user->rank_id != null ? $user->rank->department->faction->id : null),
			selectedDepartment: @json($user->rank_id != null ? $user->rank->department->id : null),
			selectedRank: @json($user->rank_id != null ? $user->rank_id : null),

			get filteredDepartments() {
				if(this.selectedFaction == null) return []
				return this.departments.filter(x => x.faction_id == this.selectedFaction)
			},
			get filteredRanks() {
				if(this.selectedDepartment == null) return []
				return this.ranks.filter(x => x.department_id == this.selectedDepartment)
			},
		}
	}
	</script>
</x-rancor::admin-layout>