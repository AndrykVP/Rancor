<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Fonts -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

      <!-- Styles -->
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">

      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}" defer></script>
   </head>
   <body class="font-sans antialiased flex">

      <aside class="relative bg-indigo-800 h-screen w-64 hidden sm:block shadow-xl">
         <nav class="text-white text-base font-semibold p-0">
            <div class="text-sm text-white nav-item">
               <a href="{{ request()->routeIs('admin.index') ? '#' : route('admin.index') }}" class="flex justify-between w-full text-left py-3 px-4 focus:outline-none {{ request()->routeIs('admin.index') ? 'bg-indigo-900 cursor-default' : 'hover:bg-indigo-700'}}">
                  Dashboard
               </a>
            </div>
            @foreach($links as $menu => $module)
            @if($module->isNotEmpty())
            <div x-data='{open: false}' class="text-sm text-white nav-item hover:bg-indigo-700">
               <button @click="open = !open" class="flex justify-between w-full text-left py-3 px-4 focus:outline-none" :class="{'bg-indigo-700': open}">
                  <span>{{ $menu }}</span>
                  <svg :class="{'transform rotate-180': open}" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                     <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
               </button>
               <div
               @click.away="open = false"
               x-show="open"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="transform scale-y-0"
               x-transition:enter-end="transform scale-y-100"
               x-transition:leave="transition ease-in duration-300"
               x-transition:leave-start="transform scale-y-100"
               x-transition:leave-end="transform scale-y-0"
               class="origin-top flex flex-col w-full bg-indigo-700 border-b border-indigo-600">
                  @foreach($module as $link)
                     <a href="{{ request()->routeIs('admin.' . $link['uri'] . '.*') ? '#' : route('admin.' . $link['uri'] . '.index') }}" class="text-xs pl-8 pr-4 py-2 {{ request()->routeIs('admin.' . $link['uri'] . '.*') ? 'bg-indigo-900 cursor-default' : 'hover:bg-indigo-600 '}}">{{ $link['label'] }}</a>
                  @endforeach
               </div>
            </div>
            @endif
            @endforeach
         </nav>
      </aside>
  
      <div class="w-full flex flex-col h-screen overflow-y-scroll overflow-x-hidden ">
         <!-- Desktop Header -->
         <x-rancor::main-navigation />
         
         <!-- Page Heading -->
         <header class="bg-white hidden sm:block shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                  {{ $header }}
            </div>
         </header>
  
         <!-- Mobile Header & Nav -->
         <x-rancor::admin-navigation :links="$links"/>

         @if(session('alert'))
         <x-rancor::alert :alert="session('alert')" />
         @endif
      
         <div class="w-full border-t flex flex-col">
            <main class="w-full flex-grow p-6">
               {{ $slot }}
            </main>
         </div>
          
      </div>
   </body>
</html>