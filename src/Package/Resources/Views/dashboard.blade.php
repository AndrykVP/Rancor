<x-rancor::admin-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center text-gray-500">
               {{ __('Dashboard') }}
            </li>
         </ul>
      </div>
   </x-slot>

   <div class="grid xl:grid-cols-4 lg:grid-cols-3 grid-cols-2 gap-4">
      @foreach($cards as $card)
      <div class="grid grid-cols-3 place-content-center border shadow-md rounded-md">
         <div class="col-span-1 flex justify-center px-4 py-2"><img src="https://s2.svgbox.net/hero-solid.svg?ic={{ $card['icon'] }}&color=000000" width="64" height="64"></div>
         <div class="col-span-2 flex flex-col justify-center px-4 py-2">
            <h2 class="uppercase text-xs text-gray-400 font-bold tracking-widest">{{ $card['title'] }}</h2>
            <h3 class="font-thin">{{ number_format($card['value']) }}</h3>
         </div>
      </div>
      @endforeach
   </div>
</x-rancor::admin-layout>