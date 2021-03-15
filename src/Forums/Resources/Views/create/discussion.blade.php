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
               <div>
                  <x-label for="name" :value="__('Title')" />
                  <x-input
                  type="text"
                  name="name"
                  id="name"
                  class="w-full"
                  aria-describedby="nameHelp"
                  autofocus required
                  :value="old('name')" />
                  @error('name')
                  <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                  @enderror
               </div>
               <div class="mt-4">
                  <x-label for="body" :value="__('Content')" />
                  <textarea
                  class="rounded-md w-full shadow-sm border-gray-300 @error('body') border-red-600 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="body"
                  id="body"
                  aria-describedby="bodyHelp"
                  placeholder="Enter the Content"
                  required rows="7">{!! old('body') !!}</textarea>
                  @error('body')
                  <small id="bodyHelp" class="form-text text-danger">{{ $message }}</small>
                  @enderror
               </div>

               <div class="block mt-4">
                  <label for="is_sticky" class="inline-flex items-center">
                     <input id="is_sticky" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_sticky">
                     <span class="ml-2 text-sm text-gray-600">{{ __('Make Sticky') }}</span>
                  </label>
                  <label for="is_locked" class="inline-flex items-center">
                     <input id="is_locked" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="is_locked">
                     <span class="ml-2 text-sm text-gray-600">{{ __('Locked') }}</span>
                  </label>
               </div>

               <x-button type="submit" class="mt-4">{{ __('Create Discussion') }}</x-button>
            </form>
         </div>
      </div>
   </div>
</x-rancor::main-layout>