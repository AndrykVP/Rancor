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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <x-rancor::main-navigation />

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            @if(session('alert'))
            <x-rancor::alert :alert="session('alert')" />
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

        </div>
        <footer class="w-full px-2 py-4 bg-white dark:bg-gray-800 dark:text-gray-400 border-t">
            <div class="container flex flex-wrap items-center justify-center mx-auto space-y-4 sm:justify-between sm:space-y-0">
                <p class="text-xs">
                    <span class="text-gray-500">Online Users:</span>
                    @foreach($online_users as $user)
                    <a href="{{ route('profile.show', $user) }}" class="text-indigo-800 hover:text-indigo-600">{{ $user->name }}</a>,
                    @endforeach
                </p>
            </div>
        </footer>
    </body>
</html>
