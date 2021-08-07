<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="#">{{ __('Scanner') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Entries') }}
            </li>
          </ul>
          <div class="inline-flex mt-4 md:mt-0">
            <form class="mr-4" action="{{ route('scanner.entries.search') }}" method="POST">
               @csrf
               <div class="relative text-gray-600">
                  <input type="hidden" name="attribute" value="entity_id">
                  <input type="search" name="value" placeholder="Search by id..." class="bg-white h-10 px-5 pr-10 rounded-full border-gray-300 text-sm focus:border-indigo-300 focus:outline-none" value="{{ old('value') ?? ''}}">
                  <button type="submit" class="absolute right-0 top-0 mt-3 mr-4">
                  <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve" width="512px" height="512px">
                     <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"/>
                  </svg>
                  </button>
               </div>
            </form>
             @can('create', Entry::class)
             <a class="flex justify-center items-center font-bold text-sm text-white rounded bg-green-600 px-3 py-2" href="{{ route('scanner.entries.create') }}">{{ __('Upload Scan') }}</a>
             @endcan
          </div>
      </div>
   </x-slot>
   @if($entries->total() >= config('rancor.pagination'))
   <div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
      {{ $entries->links() }}
   </div>
   @endif
 
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <x-rancor::scanner-table :entries="$entries"/>
      </div>
   </div>
</x-rancor::main-layout>