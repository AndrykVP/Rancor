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
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.category', $board->category) }}">{{ $board->category->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.board', ['category' => $board->category, 'board' => $board]) }}">{{ $board->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('New Discussion') }}
            </li>
         </ul>
      </div>
   </x-slot>


   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="border bg-white w-full md:rounded overflow-hidden px-6 py-4">
            <form action="{{ route('forums.discussions.store')}}" method="POST">
               @csrf
               <input type="hidden" name="board_id" value="{{ $board->id }}">
               <div class="mb-6">
                  <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                     {{ __('Title') }}
                  </label>
                  <input
                  type="text"
                  class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                  name="name"
                  id="name"
                  aria-describedby="nameHelp"
                  placeholder="Enter a new Title"
                  autofocus required
                  value="{{ old('name') }}">
               </div>
               <div class="mb-6">
                  <label for="body" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                     {{ __('Content') }}
                  </label>
                  <textarea
                  class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                  name="body"
                  id="body"
                  aria-describedby="bodyHelp"
                  placeholder="Enter your Reply"
                  required rows=7>{!! old('body') !!}</textarea>
               </div>
               <div class="mb-6">
                  <label for="is_sticky" class="inline-flex items-center">
                     <input
                     type="checkbox"
                     class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                     name="is_sticky"
                     id="is_sticky"
                     aria-describedby="is_stickyHelp"
                     {{ old('is_sticky') ? 'checked' : ''}}>
                     <span class="ml-2 text-sm text-gray-600">{{ __('Make Sticky') }}</span>
                  </label>
                  <label for="is_locked" class="inline-flex items-center ml-6">
                     <input
                     type="checkbox"
                     class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                     name="is_locked"
                     id="is_locked"
                     aria-describedby="is_lockedHelp"
                     {{ old('is_locked') ? 'checked' : ''}}>
                     <span class="ml-2 text-sm text-gray-600">{{ __('Locked') }}</span>
                  </label>
               </div>

               <button type="submit" class="inline-flex items-center mt-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                  {{ __('Create Discussion') }}
              </button>
            </form>
         </div>
      </div>
   </div>
</x-rancor::main-layout>