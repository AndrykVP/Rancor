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
               {{ $user->name }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @if(Route::has('admin.users.create'))
            <a href="{{ route('admin.users.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New User')}}</a>
            @endif
            @if(Route::has('admin.users.edit'))
            <a href="{{ route('admin.users.edit', $user) }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2">{{ __('Edit User')}}</a>
            @endif
         </div>
      </div>
   </x-slot>

   <div class="flex flex-col items-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
            <div class="col-span-3">{{ $user->id }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Handle:</div>
            <div class="col-span-3">{{ $user->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">E-mail:</div>
            <div class="col-span-3">{{ $user->email }}</div>
         </div>
         @if($user->rank_id != null)
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Faction:</div>
            <div class="col-span-3">{{ $user->rank->department->faction->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Department:</div>
            <div class="col-span-3">{{ $user->rank->department->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Rank:</div>
            <div class="col-span-3">{{ $user->rank->name }}</div>
         </div>
         @endif
         @if($user->roles->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Roles:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($user->roles as $role)
                  <li>{{ $role->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
         @if($user->permissions->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Permissions:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($user->permissions as $permission)
                  <li>{{ $permission->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
         @if($user->awards->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Awards:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($user->awards as $award)
                  <li class="text-sm text-gray-600">{{ $award->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Joined:</div>
            <div class="col-span-3">{{ $user->created_at->diffForHumans() }}</div>
         </div>
      </div>

      @if($user->userLog->isNotEmpty())
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
         <div class="card-header">
            {{ __('History') }}
         </div>
         <div class="card-body">
            @foreach($user->userLog as $log)
            <div class="text-sm border-bottom pb-2 mb-2">
               <span class="text-{{ $log->color }}" style="color:{{ $log->color }}">
                  {{ $log->action }}
               </span>
               <small>
                  <span>{{ $log->created_at->diffForHumans() }}</span>
                  @if($log->creator != null)
                     By <a href="{{ route('profile.show', $log->creator) }}">{{  $log->creator->name  }}</a>
                  @endif
               </small>
            </div>
            @endforeach
         </div>
      </div>
      @endif
   </div>

</x-rancor::admin-layout>