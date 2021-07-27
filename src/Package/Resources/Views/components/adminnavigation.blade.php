<div class="w-full text-white bg-indigo-900 sm:hidden">
   <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl mx-auto md:items-center md:justify-between md:flex-row">
      <div class="py-4 px-4 md:px-6 lg:px-8 flex flex-row items-center justify-between">
         <a href="{{ route('admin.index') }}" class="text-lg font-semibold tracking-widest uppercase rounded-lg focus:outline-none focus:shadow-outline">Admin</a>
         <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
               <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
               <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
         </button>
      </div>
      <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow md:pb-0 hidden md:flex md:justify-end md:flex-row">
         @foreach($links as $menu => $module)
         @if($module->isNotEmpty())
         <div x-data='{open: false}' class="text-white nav-item">
            <button @click="open = !open" class="flex justify-between w-full text-left py-3 px-6 focus:outline-none" :class="{'bg-indigo-800': open}">
               <span>{{ $menu }}</span>
               <svg :class="{'transform rotate-180': open}" class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
               </svg>
            </button>
            <div 
            @click.away="open = false"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-y-0"
            x-transition:enter-end="opacity-100 transform scale-y-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-y-100"
            x-transition:leave-end="opacity-0 transform scale-y-0"
            class="origin-top flex flex-col w-full bg-indigo-800 border-t border-indigo-600">
               @foreach($module as $link)
                  <a href="{{ request()->routeIs('admin.' . $link['uri'] . '.*') ? '#' : route('admin.' . $link['uri'] . '.index')}}" class="text-sm hover:bg-indigo-600 px-4 py-2 {{ request()->routeIs('admin.' . $link['uri'] . '.*') ? 'bg-indigo-600 cursor-default' : ''}}">{{ $link['label'] }}</a>
               @endforeach
            </div>
         </div>
         @endif
         @endforeach
      </nav>
   </div>
</div>