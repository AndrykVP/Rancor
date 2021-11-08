<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('profile.show', $user) }}">{{ $user->name }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Edit') }}
            </li>
         </ul>
      </div>
   </x-slot>

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">

         @if ($errors->any())
         <div class="mb-4">
            <div class="font-medium text-red-600">
               {{ __('Whoops! Something went wrong.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
               @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
         @endif
         
         <form action="{{ route('profile.update', $user)}}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="mb-6">
               <label for="first_name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('First Name') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="first_name"
               id="first_name"
               placeholder="Edit the User's Handle"
               required autofocus
               value="{{ old('first_name') ?: $user->first_name }}" />
            </div>
            <div class="mb-6">
               <label for="last_name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Last Name') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="last_name"
               id="last_name"
               placeholder="Edit the User's Handle"
               required autofocus
               value="{{ old('last_name') ?: $user->last_name }}" />
            </div>
            <div class="mb-6">
               <label for="nickname" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Nickname') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="nickname"
               id="nickname"
               placeholder="Edit the User's Nickname"
               required
               value="{{ old('nickname') ?: $user->nickname }}" />
            </div>
            <div class="mb-6">
               <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('E-mail') }}
               </label>
               <input
               type="email"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="email"
               id="email"
               placeholder="Edit the User's E-mail"
               required
               value="{{ old('email') ?: $user->email }}" />
            </div>
            <div class="mb-6">
               <label for="quote" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ _('Quote') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="quote"
               id="quote"
               placeholder="Edit the User's Quote"
               required
               value="{{ old('quote') ?: $user->quote }}" />
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
               {{ __('Apply Changes') }}
           </button>
         </form>
      </div>
   </div>
</x-rancor::main-layout>