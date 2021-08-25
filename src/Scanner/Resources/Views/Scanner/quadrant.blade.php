<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               {{ __('Scanner') }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @can('create', \AndrykVP\Rancor\Scanner\Models\Entry::class)
            <a class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-blue-600 p-2 md:px-3 md:py-2 ml-2 md:ml-3" href="{{ route('scanner.create') }}">{{ __('Upload Scan') }}</a>
            @endcan
         </div>
      </div>
   </x-slot>

   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         <div class="border w-full md:w-3/4 md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
            Scanner Quadrant
         </div>
      </div>
   </div>
</x-rancor::main-layout>