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

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">

         <x-auth-validation-errors class="mb-4" :errors="$errors" />
         
         <form action="{{ route('admin.users.update', $user)}}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="mb-6">
               <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Handle') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="name"
               id="name"
               placeholder="Edit the User's Handle"
               required autofocus
               value="{{ old('name') ?: $user->name }}" />
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
               required
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
               required
               value="{{ old('quote') ?: $user->quote }}" />
            </div>
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
               <label for="avatar" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Avatar') }}
               </label>
               <input
               type="file"
               accept="image/png" 
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="avatar"
               id="avatar"
               placeholder="Upload User's Avatar">
            </div>
            <div class="mb-6">
               <label for="signature" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Signature') }}
               </label>
               <input
               type="file"
               accept="image/png" 
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="signature"
               id="signature"
               placeholder="Upload User's Signature">
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
            <x-button type="submit">Apply Changes</x-button>
         </form>
      </div>
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