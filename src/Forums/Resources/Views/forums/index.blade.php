<x-rancor::main-layout>
   <x-slot name="header">
      <ul class="flex text-sm lg:text-base">
         <li class="inline-flex items-center">
            Forums
         </li>
       </ul>
   </x-slot>
 
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @foreach ($categories as $category)
            <x-rancor::category-card :category="$category"/>
         @endforeach
      </div>
   </div>
</x-rancor::main-layout>