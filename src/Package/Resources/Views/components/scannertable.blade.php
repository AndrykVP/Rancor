<div class="border w-full md:rounded overflow-hidden md:shadow-lg mb-4">
   <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50 text-gray-500 text-xs font-medium uppercase tracking-wider">
         <tr>
            <th class="p-3">{{ __('ID') }}</th>
            <th class="p-3 text-left">{{ __('Information') }}</th>
            <th class="p-3 text-left">{{ __('Last Position') }}</th>
            <th class="p-3 text-left">{{ __('Last Seen') }}</th>
            <th class="p-3 text-left">{{ __('Action') }}</th>
         </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200 text-xs md:text-base">
         @forelse ($entries as $entry)
         <tr id="{{ $entry->id }}">
            <td class="p-3">
               #{{ $entry->entity_id }}
            </td>
            <td class="p-3">
               <strong>Type:</strong> {{ $entry->type }}<br />
               <strong>Name:</strong> {{ $entry->name }}<br />
               <strong>Owner:</strong> {{ $entry->owner }}
            </td>
            <td class="p-3">
               <strong>System:</strong> ({{ $entry->position['galaxy']['x'] }}, {{ $entry->position['galaxy']['y'] }})<br />
               <strong>Orbit:</strong> ({{ $entry->position['system']['x'] }}, {{ $entry->position['system']['y'] }})
               @if(array_key_exists('surface', $entry->position))
               <br/><strong>Surface:</strong> ({{ $entry->position['surface']['x'] }}, {{ $entry->position['surface']['y'] }})
               @endif
               @if(array_key_exists('ground', $entry->position))
               <br/><strong>Ground:</strong> ({{ $entry->position['ground']['x'] }}, {{ $entry->position['ground']['y'] }})
               @endif
            </td>
            <td class="p-3">
               {{ $entry->last_seen->diffForHumans() }}<br />
               By {{ $entry->contributor->name }}
            </td>
            <td class="py-3">
               <a href="{{ route('scanner.entries.show', $entry) }}" class="bg-blue-600 hover:bg-blue-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('View') }}">
                  <svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                     <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                     <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                  </svg>
               </a>
               @can('update', $entry)
               <a href="{{ route('scanner.entries.edit', $entry) }}" class="bg-green-600 hover:bg-green-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Edit') }}">
                  <svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                     <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                  </svg>
               </a>
               @endcan
               @can('delete', $entry)
               
               <a href="{{ route('scanner.entries.destroy', $entry) }}" class="bg-red-600 hover:bg-red-500 text-gray-100 font-bold py-1 px-2 rounded inline-flex items-center" title="{{ __('Delete') }}"
               onclick="event.preventDefault();
               document.getElementById('{{ 'delete-entry-' . $entry->id }}').submit();">
                  <svg width="14" height="14" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                     <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
               </a>

               <form id="{{ 'delete-entry-' . $entry->id }}" action="{{ route('scanner.entries.destroy', $entry) }}" method="POST" style="display: none;">
                  @method('DELETE')
                  @csrf
               </form>
               @endcan
            </td>
         </tr>
         @empty
         <tr>
            <td colspan="5" class="text-center text-gray-500 font-bold uppercase tracking-wider py-6">{{ __('No Entries Found') }}</td>
         </tr>
         @endforelse
      </tbody>
   </table>
</div>