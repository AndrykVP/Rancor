<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               {{ __('Forums') }}
            </li>
          </ul>
          <div class="inline-flex">
             @can('create', Category::class)
             <a class="flex justify-center items-center font-bold text-sm text-white rounded bg-green-600 px-3 py-2" href="{{ route('admin.categories.create') }}">{{ __('New Category') }}</a>
             @endcan
          </div>
      </div>
   </x-slot>
 
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @if($categories->isNotEmpty())
            @foreach ($categories as $category)
               <x-rancor::category-card :category="$category"/>
            @endforeach
         @else
         <div class="border w-full md:w-3/4 md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
            No Categories Found
         </div>
         @endif
      </div>
   </div>
</x-rancor::main-layout>