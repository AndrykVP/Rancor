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
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('forums.category', $category) }}">{{ $category->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ $board->name }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @can('update',$board)
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2" href="{{ route('admin.boards.edit', $board) }}">{{ __('Edit Board') }}</a>
            @endcan
            @can('create', \AndrykVP\Rancor\Forums\Models\Board::class)
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('admin.boards.create', ['parent' => $board]) }}">{{ __('New Child Board') }}</a>
            @endcan
            @can('create', [\AndrykVP\Rancor\Forums\Models\Discussion::class, $board])
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('forums.discussions.create', ['board' => $board]) }}">{{ __('New Discussion') }}</a>
            @endcan
            @can('delete',$board)
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-red-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="#">{{ __('Delete Board') }}</a>
            @endcan
         </div>
      </div>
   </x-slot>
   
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @if($board->children->isNotEmpty() || $sticky->isNotEmpty() || $normal->isNotEmpty())
            @if($board->children->isNotEmpty())
            <div class="border w-full md:rounded overflow-hidden md:shadow-lg mb-4">
               <div class="border-b p-4 text-white">
                  {{ __('Children Boards') }}
               </div>
               <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                     <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Boards</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest</th>
                     </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                     @foreach($board->children as $board)
                        <x-rancor::board-row :board="$board" />
                     @endforeach
                  </tbody>
               </table>
            </div>
            @endif
            @if($sticky->isNotEmpty())
            <x-rancor::discussion-list title="{{ __('Sticky Discussions') }}" :discussions="$sticky" :board="$board" :category="$category"/>
            @endif
            @if($normal->isNotEmpty())
            <x-rancor::discussion-list title="{{ __('Regular Discussions') }}" :discussions="$normal" :board="$board" :category="$category"/>
            @endif
         @else
         <div class="row justify-content-center">
            <div class="col">
               <div class="card mb-4">
                  <div class="card-body">No Child Boards or Discussions found in this Board</div>
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</x-rancor::main-layout>