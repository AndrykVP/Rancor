<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="#">{{ __('Scanner') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('scanner.entries.index') }}">{{ __('Entries') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Edit') }}
            </li>
         </ul>
         <div class="inline-flex mt-4 md:mt-0">
            @can('create', Entry::class)
            <a href="{{ route('scanner.entries.create') }}" class="flex justify-center items-center font-bold text-xs md:text-sm text-white rounded bg-green-600 p-2 md:px-3 md:py-2">{{ __('Upload Scan')}}</a>
            @endcan
         </div>
      </div>
   </x-slot>

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">

         <x-auth-validation-errors class="mb-4" :errors="$errors" />
         
         <form action="{{ route('scanner.entries.update', $entry)}}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $entry->id }}">
            <div class="mb-6">
               <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ __('Name') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="name"
               id="name"
               aria-describedby="nameHelp"
               placeholder="Edit the Name"
               required autofocus
               value="{{ old('name') ?? $entry->name }}" />
            </div>
            <div class="mb-6">
               <label for="entity_id" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ __('Entity ID') }}
               </label>
               <input
               type="number"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="entity_id"
               id="entity_id"
               aria-describedby="entityIDHelp"
               placeholder="Edit the Entity ID"
               required
               value="{{ old('entity_id') ?? $entry->entity_id }}" />
            </div>
            <div class="mb-6">
               <label for="owner" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ __('Owner') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="owner"
               id="owner"
               aria-describedby="ownerHelp"
               placeholder="Edit the Owner"
               required
               value="{{ old('owner') ?? $entry->owner }}" />
            </div>
            <div class="mb-6">
               <label for="type" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                  {{ __('Type') }}
               </label>
               <input
               type="text"
               class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
               name="type"
               id="type"
               aria-describedby="typeHelp"
               placeholder="Edit the Type"
               required
               value="{{ old('type') ?? $entry->type }}" />
            </div>
            <x-button type="submit">Apply Changes</x-button>
         </form>
      </div>
   </div>
</x-rancor::main-layout>