
<div class="border w-full md:rounded overflow-hidden md:shadow-lg mb-4">
   <div class="border-b p-4">
      {{ $title }}
   </div>
   @if($discussions->count() > 0)
   <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
         <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Boards</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest</th>
         </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
         @foreach($discussions as $discussion)
         <tr>
            <td class="px-6 py-4 whitespace-nowrap">
               <div class="flex items-center">
                  <a class="font-bold text-xl text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $category, 'board' => $board, 'discussion' => $discussion]) }}">
                     {{ $discussion->name }}
                     @if($discussion->visitors->isNotEmpty() && $discussion->visitors[0]->unread->reply_count > 0)
                     <span class="absolute items-center justify-center px-2 py-1 -ml-3 -mt-3 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ number_format($discussion->visitors[0]->unread->reply_count) }}</span>
                     @endif
                  </a>
                  @if($discussion->is_locked)
                  <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                  @endif
                  <span class="text-xs text-gray-700 ml-4">({{ number_format($discussion->views) }} {{ __('Views') }}. {{ number_format($discussion->replies_count) }} {{ __('Replies') }})</span>
               </div>
               <div>
                  @if($discussion->pages > 1)
                  <div class="text-sm">
                  «
                  @for($i = 1; $i <= $discussion->pages; $i++)
                     <a class="text-sm text-indigo-700 hover:text-indigo-400" href="{{ route('forums.discussion', ['category' => $category, 'board' => $board, 'discussion' => $discussion, 'page' => $i]) }}">{{ $i }}</a>,
                  @endfor
                  »</div>
                  @endif
               </div>
            </td>
            <td class="col-3">
               @if($discussion->replies_count > 0)
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.discussion', ['category' => $category, 'board' => $board, 'discussion' => $discussion, 'page' => $discussion->latest_reply->page->number]).'#'.$discussion->latest_reply->page->index}}">{{ $discussion->latest_reply->created_at->diffForHumans() }}</a><br/>
               By <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.show', $discussion->latest_reply->author) }}">{{ $discussion->latest_reply->author->name }}</a>
               @else
               No Posts Yet
               @endif
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   @else
   <div class="bg-white p-4">
      {{ ('No Discussions to Display') }}
   </div>
   @endif
</div>