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
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.category', $reply->discussion->board->category) }}">{{ $reply->discussion->board->category->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.board', ['category' => $reply->discussion->board->category, 'board' => $reply->discussion->board]) }}">{{ $reply->discussion->board->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $reply->discussion->board->category, 'board' => $reply->discussion->board, 'discussion' => $reply->discussion]) }}">{{ $reply->discussion->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Edit Reply') }}
            </li>
         </ul>
      </div>
   </x-slot>


   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="border bg-white w-full md:rounded overflow-hidden px-6 py-4">
            <form action="{{ route('forums.replies.update', ['reply' => $reply]) }}" method="POST">
               @method('PATCH')
               @csrf
               <input type="hidden" name="discussion_id" value="{{ $reply->discussion_id }}">
               <div>
                  <label for="body">{{ __('Content') }}</label>
                  @error('body')
                  <small id="bodyHelp" class="text-red-600">{{ 'Error' }}</small>
                  @enderror
                  <textarea
                  class="rounded-md w-full shadow-sm border-gray-300 @error('body') border-red-600 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  name="body"
                  id="body"
                  aria-describedby="bodyHelp"
                  placeholder="Enter the Content"
                  autofocus required rows="7">{!! old('body') ?: $reply->body !!}</textarea>
               </div>
               <button type="submit" class="ml-3">{{ __('Post') }}</button>
            </form>
         </div>
      </div>
   </div>
</x-rancor::main-layout>