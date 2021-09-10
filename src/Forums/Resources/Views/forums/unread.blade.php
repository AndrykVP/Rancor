<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.index') }}">{{ __('Forums') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Unread Discussions') }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            <form id="markread" action="{{ route('forums.unread.mark') }}" method="POST">
               @csrf
               <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                  {{ __('Mark All Read') }}
               </button>
            </form>
         </div>
      </div>
   </x-slot>
   @if($unread->count() > config('rancor.pagination'))
   <div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
      {{ $unread->links() }}
   </div>
   @endif

   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <x-rancor::unread-list :discussions="$unread"/>
         </div>
      </div>
   </div>
</x-rancor::main-layout>