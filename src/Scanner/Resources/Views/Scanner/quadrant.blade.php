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
            @can('create', \AndrykVP\Rancor\Scanner\Models\Entry::class)
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('scanner.create') }}">{{ __('Upload Scan') }}</a>
            @endcan
         </div>
      </div>
   </x-slot>

   <div x-data="getData()" class="py-12">
      <div class="grid md:grid-cols-5 max-w-7xl mx-auto sm:px-6 lg:px-8 gap-4">
         {{-- Cursor Box --}}
         <div class="md:col-span-2 row-span-1 border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4">
            <span x-text="'Cursor Coordinates: ' + coordinates"></span>
         </div>

         {{-- Grid Box --}}
         <div class="md:col-span-3 row-span-3 md:order-first border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4" @mouseover.away="coordinates = ''">
            <h1 class="text-lg text-bold">Grid</h1>
            <div class="flex justify-center">
               <div class="border flex flex-wrap" style="width: 390px; height: 390; background: url({{ asset('quadrants/' . $quadrant->id . '.jpg') }});">
                  <template x-for="(group, index) in territories" :key="index">
                     <div class="flex flex-row flex-nowrap w-full">
                        <template x-for="territory in JSON.parse(JSON.stringify(group))" :key="territory.id">
                           <div class="border" style="width:30px; height:30px;" @click="setTerritory(territory)" @mouseover="getCoordinates(territory)" :class="(selectedTerritory != null && selectedTerritory.id == territory.id) ? 'border-green-600' : ''">
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
                  <div class="md:w-2/3">
                     <span class="w-full dark:bg-gray-700 dark:text-white" x-text="date"></span>
                  </div>
               </div>
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

         {{-- Quadrant Navigation --}}
         <div class="md:col-span-2 row-span-3 border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0 p-4">
            <span x-text="'Navigate Quadrant'"></span>
         </div>
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
            if(territory.last_patrol != null) {
               let date = new Date(territory.last_patrol);
               this.date = date.toLocaleString('en-US');
            }
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