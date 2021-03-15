<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Scripts -->
   <script src="{{ asset('js/app.js') }}" defer></script>
   @stack('scripts')

   <!-- Fonts -->
   <link rel="dns-prefetch" href="//fonts.gstatic.com">
   <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

   <!-- Styles -->
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
   <div id="app">
      <div class="d-flex" id="wrapper">

         <!-- Sidebar -->
         <div class="bg-white border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Admin Panel</div>
            <div class="list-group list-group-flush">
               <a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action {{ Request::is('admin') ? 'active' : '' }}">
                  <svg class="mr-4" width="20" height="20" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path></svg>
                  {{ __('Dashboard') }}
               </a>
               @if( Auth::user()->can('viewAny', \App\Models\User::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Auth\Models\Permission::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Auth\Models\Role::class))
               <button class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['users', 'roles', 'permissions']) ? 'active' : '' }}" data-toggle="collapse" data-target="#auth" aria-expanded="false" aria-controls="auth">
                  <svg class="mr-4" width="20" height="20" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                  {{ __('Authentication') }}
               </button>
               <div id="auth" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \App\Models\User::class)
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'users' ? 'active' : '' }}">{{ __('Users') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Auth\Models\Role::class)
                    <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'roles' ? 'active' : '' }}">{{ __('Roles') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Auth\Models\Permission::class)
                    <a href="{{ route('admin.permissions.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'permissions' ? 'active' : '' }}">{{ __('Permissions') }}</a>
                    @endcan
                  </div>
               </div>
               @endif
               @if( Auth::user()->can('viewAny', \AndrykVP\Rancor\Structure\Models\Faction::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Structure\Models\Department::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Structure\Models\Rank::class ) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Structure\Models\Award::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Structure\Models\Type::class))
               <button class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['factions', 'departments', 'ranks', 'awards', 'types']) ? 'active' : '' }}" data-toggle="collapse" data-target="#structure" aria-expanded="false" aria-controls="structure">
                  <svg class="mr-4" width="20" height="20" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path></svg>
                  {{ __('Structure') }}
               </button>
               <div id="structure" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \AndrykVP\Rancor\Structure\Models\Faction::class)
                    <a href="{{ route('admin.factions.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'factions' ? 'active' : '' }}">{{ __('Factions') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Structure\Models\Department::class)
                    <a href="{{ route('admin.departments.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'departments' ? 'active' : '' }}">{{ __('Departments') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Structure\Models\Rank::class)
                    <a href="{{ route('admin.ranks.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'ranks' ? 'active' : '' }}">{{ __('Ranks') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Structure\Models\Award::class)
                    <a href="{{ route('admin.awards.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'awards' ? 'active' : '' }}">{{ __('Awards') }}</a>
                    @endcan
                    @can('viewAny', \AndrykVP\Rancor\Structure\Models\Type::class)
                    <a href="{{ route('admin.types.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'types' ? 'active' : '' }}">{{ __('Award Types') }}</a>
                    @endcan
                  </div>
               </div>
               @endif
               @if( Auth::user()->can('viewAny', \AndrykVP\Rancor\News\Models\Article::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\News\Models\Tag::class))
               <button class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['articles', 'tags']) ? 'active' : '' }}" data-toggle="collapse" data-target="#news" aria-expanded="false" aria-controls="news">
                  <svg class="mr-4" width="20" height="20" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path xmlns="http://www.w3.org/2000/svg" d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>
                  {{ __('News') }}
               </button>
               <div id="news" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \AndrykVP\Rancor\News\Models\Article::class)
                     <a href="{{ route('admin.articles.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'articles' ? 'active' : '' }}">{{ __('Articles') }}</a>
                     @endcan
                     @can('viewAny', \AndrykVP\Rancor\News\Models\Tag::class)
                     <a href="{{ route('admin.tags.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'tags' ? 'active' : '' }}">{{ __('Tags') }}</a>
                     @endcan
                  </div>
               </div>
               @endif
               @if( Auth::user()->can('viewAny', \AndrykVP\Rancor\Forums\Models\Group::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Forums\Models\Category::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Forums\Models\Board::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Forums\Models\Discussion::class))
               <button class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['groups', 'categories', 'boards', 'discussions']) ? 'active' : '' }}" data-toggle="collapse" data-target="#forums" aria-expanded="false" aria-controls="forums">
                  <svg class="mr-4" width="20" height="20" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio"><path xmlns="http://www.w3.org/2000/svg" d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path xmlns="http://www.w3.org/2000/svg" d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>
                  {{ __('Forums') }}
               </button>
               <div id="forums" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \AndrykVP\Rancor\Forums\Models\Group::class)
                     <a href="{{ route('admin.groups.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'groups' ? 'active' : '' }}">{{ __('Groups') }}</a>
                     @endcan
                     @can('viewAny', \AndrykVP\Rancor\Forums\Models\Category::class)
                     <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'categories' ? 'active' : '' }}">{{ __('Categories') }}</a>
                     @endcan
                     @can('viewAny', \AndrykVP\Rancor\Forums\Models\Board::class)
                     <a href="{{ route('admin.boards.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'boards' ? 'active' : '' }}">{{ __('Boards') }}</a>
                     @endcan
                     @can('viewAny', \AndrykVP\Rancor\Forums\Models\Discussion::class)
                     <a href="{{ route('admin.discussions.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'discussions' ? 'active' : '' }}">{{ __('Discussions') }}</a>
                     @endcan
                  </div>
               </div>
               @endif
               @if( Auth::user()->can('viewAny', \AndrykVP\Rancor\Holocron\Models\Node::class) || Auth::user()->can('viewAny', \AndrykVP\Rancor\Holocron\Models\Collection::class))
               <button class="list-group-item list-group-item-action {{ in_array(Request::segment(2), ['nodes', 'collections']) ? 'active' : '' }}" data-toggle="collapse" data-target="#holocron" aria-expanded="false" aria-controls="holocron">
                  <svg class="mr-4" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
                  {{ __('Holocron') }}
               </button>
               <div id="holocron" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \AndrykVP\Rancor\Holocron\Models\Node::class)
                     <a href="{{ route('admin.nodes.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'nodes' ? 'active' : '' }}">{{ __('Nodes') }}</a>
                     @endcan
                     @can('viewAny', \AndrykVP\Rancor\Holocron\Models\Collection::class)
                     <a href="{{ route('admin.collections.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'collections' ? 'active' : '' }}">{{ __('Collections') }}</a>
                     @endcan
                  </div>
               </div>
               @endif
               @if( Auth::user()->can('viewAny', \AndrykVP\Rancor\Scanner\Models\Entry::class))
               <button class="list-group-item list-group-item-action {{ Request::segment(2) == 'entries' ? 'active' : '' }}" data-toggle="collapse" data-target="#scanner" aria-expanded="false" aria-controls="scanner">
                  <svg class="mr-4" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                  {{ __('Scanner') }}
               </button>
               <div id="scanner" class="collapse" data-parent="#sidebar-wrapper">
                  <div class="list-group list-group-flush">
                     @can('viewAny', \AndrykVP\Rancor\Scanner\Models\Entry::class)
                     <a href="{{ route('admin.entries.index') }}" class="list-group-item list-group-item-secondary small text-uppercase list-group-item-action {{ Request::segment(2) == 'entries' ? 'active' : '' }}">{{ __('Entries') }}</a>
                     @endcan
                  </div>
               </div>
               @endif
            </div>
         </div>
         <!-- /#sidebar-wrapper -->

         <!-- Page Content -->
         <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
               <div class="container">
                  <button class="btn btn-primary" type="button" id="menu-toggle" onclick="toggleSidebar()">Toggle Sidebar</button>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                     <span class="navbar-toggler-icon"></span>
                  </button>

                  @include('rancor::components.navigation')
            </nav>

            <div class="container-fluid">
               @if(session('alert'))
               <div class="alert alert-success" role="alert">
                  {{ session('alert') }}
               </div>
               @endif

               <div class="py-4">
                  @yield('content')
               </div>
            </div>
         </div>
         <!-- /#page-content-wrapper -->     
      </div> 
   </div>
   <!-- Menu Toggle Script -->
   @yield('scripts')
   <script>
      function toggleSidebar() {
         var element = document.getElementById("wrapper");
         element.classList.toggle("toggled");
      }
   </script>
</body>


<style>
   /*!
   * Start Bootstrap - Simple Sidebar (https://startbootstrap.com/template/simple-sidebar)
   * Copyright 2013-2020 Start Bootstrap
   * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
   */

   #wrapper {
      overflow-x: hidden;
   }

   #sidebar-wrapper {
      min-height: 100vh;
      margin-left: -15rem;
      -webkit-transition: margin .25s ease-out;
      -moz-transition: margin .25s ease-out;
      -o-transition: margin .25s ease-out;
      transition: margin .25s ease-out;
   }

   #sidebar-wrapper .sidebar-heading {
      padding: 0.875rem 1.25rem;
      font-size: 1.2rem;
   }

   #sidebar-wrapper .list-group {
      width: 15rem;
   }

   #page-content-wrapper {
      min-width: 100vw;
   }

   #wrapper.toggled #sidebar-wrapper {
      margin-left: 0;
   }

   @media (min-width: 768px) {
      #sidebar-wrapper {
         margin-left: 0;
      }

      #page-content-wrapper {
         min-width: 0;
         width: 100%;
      }

      #wrapper.toggled #sidebar-wrapper {
         margin-left: -15rem;
      }
   }
</style>
</html>
