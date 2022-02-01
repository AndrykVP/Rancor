<x-rancor::admin-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="#">{{ __('Scanner') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.entries.index') }}">{{ __('Entries') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               #{{ $entry->entity_id }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @can('update', $entry)
            <a class="flex justify-center items-center font-bold text-sm text-white rounded bg-green-600 px-3 py-2" href="{{ route('admin.entries.edit', $entry) }}">{{ __('Edit Entry') }}</a>
            @endcan
            @can('delete', $entry)
            <a class="flex justify-center items-center font-bold text-sm text-white rounded bg-red-600 px-3 py-2 ml-2" href="{{ route('admin.entries.destroy', $entry) }}">{{ __('Delete Entry') }}</a>
            @endcan
         </div>
      </div>
   </x-slot>

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">ID:</div>
            <div class="col-span-3">{{ $entry->id }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Entity ID:</div>
            <div class="col-span-3">{{ $entry->entity_id }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Type:</div>
            <div class="col-span-3">{{ $entry->type }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Name:</div>
            <div class="col-span-3">{{ $entry->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Owner:</div>
            <div class="col-span-3">{{ $entry->owner }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">IFF:</div>
            <div class="col-span-3">{{ $entry->alliance->value }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">System:</div>
            <div class="col-span-3">{{ $entry->territory->name != null ? $entry->territory->name : 'Deep Space' }} ({{ $entry->territory->x_coordinate}}, {{ $entry->territory->y_coordinate }})</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-top">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Last Position:</div>
            <div class="col-span-3">
            @if($entry->position != null)
               <strong>Orbit:</strong> ({{ $entry->position['orbit']['x'] }}, {{ $entry->position['orbit']['y'] }})
               @if(array_key_exists('atmosphere', $entry->position))
               <br/><strong>Atmosphere:</strong> ({{ $entry->position['atmosphere']['x'] }}, {{ $entry->position['atmosphere']['y'] }})
               @endif
               @if(array_key_exists('ground', $entry->position))
               <br/><strong>Ground:</strong> ({{ $entry->position['ground']['x'] }}, {{ $entry->position['ground']['y'] }})
               @endif
               @else
               None
            @endif
            </div>

         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Contributor:</div>
            <div class="col-span-3">{{ $entry->contributor->name }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Last Seen:</div>
            <div class="col-span-3">
               @if($entry->last_seen != null)
               {{ $entry->last_seen->diffForHumans() }}
               @else
               None
               @endif
            </div>

         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Last Update:</div>
            <div class="col-span-3">{{ $entry->updated_at->diffForHumans() }}</div>
         </div>
         <div class="grid grid-cols-4 mb-2 gap-4 items-center">
            <div class="col-span-1 text-right uppercase text-xs tracking-wider text-gray-600">Changes:</div>
            <div class="col-span-3">{{ number_format($entry->changelog->count()) }}</div>
         </div>
      </div>
   </div>
</x-rancor::admin-layout>