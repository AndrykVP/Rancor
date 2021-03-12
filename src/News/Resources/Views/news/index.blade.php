<x-rancor::main-layout>
   <x-slot name="header">
      {{ $articles->links() }}
   </x-slot>
 
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="flex flex-wrap md:flex-nowrap justify-between">
            <div class="border w-full md:w-3/4 md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
               @foreach ($articles as $article)
               <div class="border-b px-6 py-4">
                  <div class="py-2">
                     <div class="flex justify-between">
                        <a href="{{ route('news.show', $article) }}" class="font-bold text-xl hover:text-indigo-900 transition ease-in-out duration-200">{{ $article->name }}</a>
                        @can('update', $article)
                        <a href="{{ route('admin.articles.edit',$article) }}" class="bg-green-700 hover:bg-green-600 text-gray-200 py-2 px-2 rounded inline-flex items-center transition ease-in-out duration-300" title="{{ __('Edit') }}">
                           <svg class="fill-current w-4 h-4 mr-2" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                        </a>
                        @endcan
                     </div>
                     <div class="font-bold text-gray-800 mb-2">
                        @if($article->is_published)
                        <small>Published {{ $article->published_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $article->author]) }}">{{ $article->author->name }}</a></small><br />
                        @else
                        <small>Created {{ $article->created_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $article->author]) }}">{{ $article->author->name }}</a></small><br />
                        @endif
                        @if($article->editor != null)
                        <small>Last edited {{ $article->updated_at->diffForHumans() }} by <a class="text-indigo-800 hover:text-indigo-700" href="{{ route('admin.users.show', ['user' => $article->editor]) }}">{{ $article->editor->name }}</a></small><br />
                        @endif
                     </div>
                     <p class="text-gray-700 text-base mb-2">
                        {{ $article->description }}
                     </p>
                  </div>
                  <div class="py-2 mb-4">
                     <a href="{{ route('news.show', $article) }}" class="bg-indigo-600 px-4 py-2 text-white rounded">Read More</a>
                  </div>
                  <div class="py-2">
                     @foreach($article->tags as $tag)
                        <a href="{{ route('news.tagged', $tag) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-900 mr-2 mb-2">
                           #{{ $tag->name }}
                        </a>
                     @endforeach
                  </div>
               </div>
               @endforeach
            </div>
             <div class="h-auto border w-full md:w-1/4 m:rounded overflow-hidden md:shadow-lg md:ml-4">
               <div class="font-bold text-xl px-4 py-4 mb-2">
                  Tags
               </div>
               @foreach($tags as $tag)
                  <a href="{{ route('news.tagged', ['tag' => $tag]) }}" class="flex justify-between items-center text-sm px-4 py-2 border-b hover:bg-indigo-100">
                     <span>#{{ $tag->name }}</span>
                     <span class="rounded-full text-xs bg-gray-200 text-gray-700 px-1 py-1">{{ number_format($tag->articles_count) }}</span>
                  </a>
               @endforeach
             </div>
          </div>
       </div>
   </div>
</x-rancor::main-layout>
