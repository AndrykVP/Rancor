<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Forum Replies') . ': ' . $user->name }}
            </li>
         </ul>
      </div>
   </x-slot>
   @if($replies->count() > config('rancor.pagination'))
   <div class="bg-white px-4 py-3 border-b border-t border-gray-200 sm:px-6">
      {{ $replies->links() }}
   </div>
   @endif

   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @forelse($replies as $reply)
         <div class="border bg-white w-full md:rounded overflow-hidden mb-4" id="{{ $reply->id }}">
            <div class="border-b bg-gray-200 text-xs p-4">
               Posted {{ $reply->created_at->diffForHumans() }} on <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $reply->discussion->board->category, 'board' => $reply->discussion->board, 'discussion' => $reply->discussion, 'page' => $reply->page->number]) . '#' . $reply->page->index }}">{{ $reply->discussion->name }}</a>
            </div>
            <div class="px-4 py-2">
               {!!($reply->body) !!}
            </div>
         </div>
         @empty
         <div class="border bg-white w-full md:rounded overflow-hidden mb-4">
            No Replies by this User
         </div>
         @endforelse
      </div>
   </div>
</x-rancor::main-layout>