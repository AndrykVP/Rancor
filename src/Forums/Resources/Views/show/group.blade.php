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
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.groups.index') }}">{{ __('Groups') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ $group->name }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @if(Route::has('admin.groups.create'))
            <a href="{{ route('admin.groups.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('New Group')}}</a>
            @endif
            @if(Route::has('admin.groups.edit'))
            <a href="{{ route('admin.groups.edit', $group) }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2">{{ __('Edit Group')}}</a>
            @endif
         </div>
      </div>
   </x-slot>

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
            <div class="col-span-3">{{ $group->id }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Name:</div>
            <div class="col-span-3">{{ $group->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Description:</div>
            <div class="col-span-3">{{ $group->description }}</div>
         </div>
         @if($group->categories->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Categories:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($group->categories as $category)
                  <li>{{ $category->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
         @if($group->boards->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Boards:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($group->boards as $board)
                  <li>{{ $board->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
         @if($group->users->isNotEmpty())
         <div class="grid grid-cols-4 mb-2 gap-4 items-start">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Users:</div>
            <div class="col-span-3">
               <ul>
                  @foreach($group->users as $user)
                  <li class="text-sm">{{ $user->name }}</li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endif
      </div>
   </div>
</x-rancor::admin-layout>