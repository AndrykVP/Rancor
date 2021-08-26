<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               {{ __('Forums') }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @can('create', \AndrykVP\Rancor\Forums\Models\Category::class)
            <a class="flex justify-center items-center font-bold text-sm text-white rounded bg-green-600 px-3 py-2" href="{{ route('admin.categories.create') }}">{{ __('New Category') }}</a>
            @endcan
         </div>
      </div>
   </x-slot>
 
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @forelse ($categories as $category)
            <x-rancor::category-card :category="$category"/>
         @empty
         <div class="border bg-white w-full md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
            <div class="p-4">
               <strong>No Categories Found</strong>
            </div>
         </div>
         @endforelse
      </div>
   </div>
</x-rancor::main-layout>