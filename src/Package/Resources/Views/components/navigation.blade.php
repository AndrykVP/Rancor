
<div class="collapse navbar-collapse" id="navbarSupportedContent">
   <!-- Left Side Of Navbar -->
   <ul class="navbar-nav mr-auto">

   </ul>

   <!-- Right Side Of Navbar -->
   <ul class="navbar-nav ml-auto">
      <li class="nav-item">
         <a class="nav-link" href="{{ route('holocron.index') }}">{{ __('Holocron') }}</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" href="{{ route('news.index') }}">{{ __('Press') }}</a>
      </li>
      <!-- Authentication Links -->
      @guest
         <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
         </li>
         @if (Route::has('register'))
            <li class="nav-item">
               <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
         @endif
      @endguest
      @auth
         <li class="nav-item">
            <a class="nav-link" href="{{ route('forums.index') }}">{{ __('Forums') }}</a>
         </li>
         <li class="nav-item">
            @if(Request::is('admin/*'))
            <a class="nav-link" href="/">{{ __('Index') }}</a>
            @else
            <a class="nav-link" href="{{ route('admin.index') }}">{{ __('Admin Panel') }}</a>
            @endif
         </li>
         <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
               {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="{{ route('profile.show', ['user' => Auth::user()]) }}">Profile</a>
               <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
               </a>

               <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
               </form>
            </div>
         </li>
      @endauth
   </ul>
</div>