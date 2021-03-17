<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
   <!-- Primary Navigation Menu -->
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
       <div class="flex justify-between h-16">
           <div class="flex">
               <!-- Logo -->
               <div class="flex-shrink-0 flex items-center">
                   <a href="{{ url('/') }}">
                       <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                   </a>
               </div>

               <!-- Navigation Links -->
               <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                  <x-nav-link :href="route('holocron.index')" :active="request()->routeIs('holocron.*')">
                     {{ __('Holocron') }}
                  </x-nav-link>
                  <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                     {{ __('Press') }}
                  </x-nav-link>
                  @auth
                     <x-nav-link :href="route('forums.index')" :active="request()->routeIs('forums.*')">
                        {{ __('Forums') }}
                     </x-nav-link>
                     <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')">
                        {{ __('Admin Panel') }}
                     </x-nav-link>
                     @endauth
                  </div>
               </div>
               
           <!-- Settings Dropdown -->
           <div class="hidden sm:flex sm:items-center sm:ml-6">
               @guest
               <a href="{{ route('login') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out mr-4">
                  {{ __('Login') }}
               </a>
               <a href="{{ route('register') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                  {{ __('Register') }}
               </a>
               @endguest
               @auth
               <x-dropdown align="right" width="48">
                   <x-slot name="trigger">
                       <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                           <div>{{ Auth::user()->name }}</div>

                           <div class="ml-1">
                               <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                   <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                               </svg>
                           </div>
                       </button>
                   </x-slot>

                   <x-slot name="content">
                       <!-- Authentication -->
                       <x-dropdown-link :href="route('profile.index')">
                           {{ __('Profile') }}
                       </x-dropdown-link>
                       <form method="POST" action="{{ route('logout') }}">
                           @csrf

                           <x-dropdown-link :href="route('logout')"
                                   onclick="event.preventDefault();
                                               this.closest('form').submit();">
                               {{ __('Log out') }}
                           </x-dropdown-link>
                       </form>
                   </x-slot>
               </x-dropdown>
               @endauth
           </div>

           <!-- Hamburger -->
           <div class="flex items-center sm:hidden">
               <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                  <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                     <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                     <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
               </button>
           </div>
       </div>
   </div>

   <!-- Responsive Navigation Menu -->
   <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
      <div class="pt-2 pb-3 space-y-1">
         <x-responsive-nav-link :href="route('holocron.index')" :active="request()->routeIs('holocron.*')">
            {{ __('Holocron') }}
         </x-responsive-nav-link>
         <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
            {{ __('Press') }}
         </x-responsive-nav-link>
         @auth
            <x-responsive-nav-link :href="route('forums.index')" :active="request()->routeIs('forums.*')">
               {{ __('Forums') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.*')">
               {{ __('Admin Panel') }}
            </x-responsive-nav-link>
         @endauth
      </div>

       <!-- Responsive Settings Options -->
       <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="space-y-1">
                  <!-- Authentication -->
                  <x-responsive-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.*')">
                     {{ __('Profile') }}
                  </x-responsive-nav-link>
                  <form method="POST" action="{{ route('logout') }}">
                     @csrf

                     <x-responsive-nav-link :href="route('logout')"
                              onclick="event.preventDefault();
                                          this.closest('form').submit();">
                        {{ __('Log out') }}
                     </x-responsive-nav-link>
                  </form>
            </div>
            @endauth
            @guest
            <div class="mt-3 space-y-1">
                  <!-- Authentication -->
                  <x-responsive-nav-link :href="route('login')">
                     {{ __('Login') }}
                  </x-responsive-nav-link>
                  <x-responsive-nav-link :href="route('register')">
                     {{ __('Register') }}
                  </x-responsive-nav-link>
            </div>
            @endguest
       </div>
   </div>
</nav>
