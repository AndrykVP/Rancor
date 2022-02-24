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
					{{ __('Quadrant') . ' ' . $quadrant->id }}
				</li>
			</ul>
			<div class="inline-flex mt-4 md:mt-0">
				<form class="mr-4" action="{{ route('scanner.search') }}" method="POST">
					@csrf
					<div class="relative text-gray-600">
						<input type="search" name="coordinates" placeholder="Search Territory..." class="bg-white h-10 px-5 pr-10 rounded-full border-gray-300 text-sm focus:border-indigo-300 focus:outline-none" value="{{ old('coordinates') ?? null }}">
						<button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
						<svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
							<path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
						</svg>
						</button>
					</div>
				</form>
				@can('create', \Rancor\Scanner\Models\Entry::class)
				<a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('scanner.create') }}">{{ __('Upload Scan') }}</a>
				@endcan
			</div>
		</div>
	</x-slot>

	<div x-data="getData()" class="py-12">
		<div class="grid gri-cols-2 md:grid-cols-5 max-w-7xl mx-auto sm:px-6 lg:px-8 gap-4">
			{{-- Cursor Box --}}
			<div class="col-span-1 row-span-1 border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4">
				<span>Cursor Coordinates</span><br />
				<span x-text="coordinates"></span>
			</div>

			{{-- Quadrant Navigation --}}
			<div class="col-span-1 row-span-1 border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4">
				<span x-text="'Navigate Quadrant'"></span>
				<div class="grid grid-cols-3 grid-rows-3 mx-auto" style="width: 72px; height: 72px;">
					<div class="col-start-2">
						@if($quadrant->y_max + 13 <= 500)
						<a href="{{ route('scanner.quadrants', ['quadrant' => $quadrant->id +1]) }}">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
							</svg>
						</a>
						@else
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
						</svg>
						@endif
					</div>
					<div class="row-start-2">
						@if($quadrant->x_min - 13 >= -500)
						<a href="{{ route('scanner.quadrants', ['quadrant' => $quadrant->id -77]) }}">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
							</svg>
						</a>
						@else
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
						</svg>
						@endif
					</div>
					<div class="row-start-2 col-start-3">
						@if($quadrant->x_max + 13 <= 500)
						<a href="{{ route('scanner.quadrants', ['quadrant' => $quadrant->id +77]) }}">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</a>
						@else
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
						</svg>
						@endif
					</div>
					<div class="row-start-3 col-start-2">
						@if($quadrant->y_min - 13 >= -500)
						<a href="{{ route('scanner.quadrants', ['quadrant' => $quadrant->id -1]) }}">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
							</svg>
						</a>
						@else
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
						</svg>
						@endif
					</div>
				</div>
			</div>

			{{-- Grid Box --}}
			<div class="col-span-2 md:col-span-3 row-span-3 md:order-first border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4" @mouseover.away="coordinates = ''">
				<h1 class="text-lg text-bold">Grid</h1>
				<div class="flex justify-center">
					<div class="flex flex-wrap" style="width: 390px; height: 390px; background: url({{ asset('scanner/background.jpg') }});">
						<template x-for="(group, index) in territories" :key="index">
							<div class="flex flex-row flex-nowrap w-full">
								<template x-for="territory in JSON.parse(JSON.stringify(group))" :key="territory.id">
									<div class="border" :style="'width:30px; height:30px; background: ' + territory.background_color" @click="setTerritory(territory)" @mouseover="getCoordinates(territory)" :class="(selectedTerritory != null && selectedTerritory.id == territory.id) ? 'border-opacity-100 border-green-600' : 'border-opacity-10 border-gray-100'">
										<img :src="territory.type ? territory.type.image : ''" />
									</div>
								</template>
							</div>
						</template>
					</div>
				</div>
			</div>

			{{-- Selected Territory Form --}}
			<template x-if="selectedTerritory != null">
				<div class="md:col-span-2 border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4">
					<h1 x-text="'Selected Location: ' + location"></h1>
					<div class="md:flex md:items-center mt-4 mb-6">
						<div class="md:w-1/3 block text-xs font-bold md:text-right mb-1 md:mb-0 pr-4">
							Last Patrol
						</div>
						<div class="md:w-2/3 dark:bg-gray-700 dark:text-white">
							<span x-text="date"></span>
						</div>
					</div>
					<template x-if="selectedTerritory.updated_by != null">
						<div class="md:flex md:items-center mt-4 mb-6">
							<div class="md:w-1/3 block text-xs font-bold md:text-right mb-1 md:mb-0 pr-4">
								Patrolled By
							</div>
							<div class="md:w-2/3 dark:bg-gray-700 dark:text-white">
								<a :href="'{{ url('/profile') }}' + '/' + selectedTerritory.contributor.id" x-text="selectedTerritory.contributor.name" class="text-indigo-800 hover:text-indigo-700"></a>
							</div>
						</div>
					</template>
					<form class="w-full" :action="'{{ url('/') }}' + '/scanner/territories/' + selectedTerritory.id + '/update'" method="POST" x-ref="form">
						@csrf
						<div class="md:flex md:items-center mb-6">
							<div class="md:w-1/3">
								<label class="block text-xs font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
									Name
								</label>
							</div>
							<div class="md:w-2/3">
								<input class="w-full placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
								name="name"
								id="inline-full-name"
								placeholder="Enter a new Name"
								type="text"
								:value="selectedTerritory.name">
							</div>
						</div>
						<div class="md:flex md:items-center mb-6">
							<div class="md:w-1/3">
								<label class="block text-xs font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-type">
									Type
								</label>
							</div>
							<div class="md:w-2/3"> 
								<select class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
								name="type_id"
								id="type"
								placeholder="Select a Faction">
									<option value="" :selected="selectedTerritory.type_id == null" class="text-gray-500" disabled>Select a Territory Type</option>
									<template x-for="type in types" :key="type.id">
										<option :value="type.id" x-text="type.name" :selected="type.id == selectedTerritory.type_id"></option>
									</template>
								</select>
							</div>
						</div>
						<div class="md:flex md:items-center mb-6">
							<div class="md:w-1/3">
								<label class="block text-xs font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-type">
									Notify Patrol
								</label>
							</div>
							<div class="md:w-2/3"> 
								<input class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
								name="subscription"
								id="subscription"
								type="checkbox"
								:checked="selectedTerritory.subscription">
							</div>
						</div>
						<div class="flex items-center mb-6">
							<div class="w-1/3 px-4">
								<button class="w-full py-1 px-2 text-white text-xs text-center font-medium border border-transparent rounded-md outline-none bg-green-700 hover:bg-green-500" type="submit">
									Update
								</button>
							</div>
							<div class="w-1/3 px-4">
								<a :href="'{{ url('/') }}' + '/scanner/territories/' + selectedTerritory.id">
									<button class="w-full py-1 px-2 text-white text-xs text-center font-medium border border-transparent rounded-md outline-none bg-blue-700 hover:bg-blue-500" type="button">
										View
									</button>
								</a>
							</div>
							<div class="w-1/3 px-4">
								<button class="w-full py-1 px-2 text-white text-xs text-center font-medium border border-transparent rounded-md outline-none bg-red-700 hover:bg-red-500" type="button" @click="formDelete()">
									Delete
								</button>
							</div>
						</div>
					</form>
				</div>
			</template>
		</div>
	</div>

 
</x-rancor::main-layout>

<script type="text/javascript">
	function getData() {
		const territories = @json($quadrant->territories->chunk(13));
		let parsedTerritories = [];

		territories.forEach(el => {
			if(typeof(el) == 'object') {
				parsedTerritories.push(Object.values(el))
			} else {
				parsedTerritories.push(el)
			}
		});

		return {
			coordinates: '',
			selectedTerritory: null,
			territories: parsedTerritories,
			types: @json($types),
			date: 'Never',
			location: null,
			setTerritory: function(territory) {
				let date = 'Never'
				if(territory.last_patrol_at != null) {
					let parsedDate = new Date(territory.last_patrol_at);
					date = parsedDate.toLocaleString('en-US');
				}
				this.date = date;
				this.selectedTerritory = territory;
				this.location = this.parseCoordinates(territory);
			},
			getCoordinates: function (territory) {
				this.coordinates = this.parseCoordinates(territory);
			},
			parseCoordinates: function(territory) {
				return `(${territory.x_coordinate}, ${territory.y_coordinate})`;
			},
			formDelete: function() {
				const form = this.$refs.form;
				var input = document.createElement("input");
					 input.type = "checkbox";
					 input.name = "delete";
					 input.classList.add("hidden");
					 input.setAttribute("checked", "");
				form.appendChild(input);
				form.submit();
			},
		}
	}
</script>