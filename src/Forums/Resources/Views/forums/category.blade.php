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
               {{ Str::limit($category->name, 15) }}
            </li>
          </ul>
          <div class="inline-flex mt-4 md:mt-0">
             @can('update',$category)
             <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2" href="{{ route('admin.categories.edit', $category) }}">{{ __('Edit Category') }}</a>
             @endcan
             @can('create', AndrykVP\Rancor\Forums\Models\Board::class)
             <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('admin.boards.create', ['category' => $category]) }}">{{ __('New Board') }}</a>
             @endcan
             @can('delete',$category)
             <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-red-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="#">{{ __('Delete Category') }}</a>
             @endcan
          </div>
      </div>
   </x-slot>
   
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <x-rancor::category-card :category="$category" :unread_discussions="$unread_discussions"/>
      </div>
   </div>
</x-rancor::main-layout>