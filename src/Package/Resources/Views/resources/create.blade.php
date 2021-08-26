<x-rancor::admin-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.index') }}">{{ __('Dashboard') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('admin.'.$resource['route'].'.index') }}">{{ Str::plural($resource['name']) }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Create') }}
            </li>
         </ul>
      </div>
   </x-slot>

   <div class="flex justify-center">
      <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white border shadow-md overflow-hidden sm:rounded-lg">

         <x-auth-validation-errors class="mb-4" :errors="$errors" />
         
         <form action="{{ route('admin.'.$resource['route'].'.store')}}" method="POST">
            @csrf
            @if(array_key_exists('hiddens',$form))
               @foreach($form['hiddens'] as $field)
               <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] }}">
               @endforeach
            @endif
            @if(array_key_exists('inputs',$form))
               @foreach($form['inputs'] as $field)
               <div class="mb-6">
                  <label for="{{ $field['name'] }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                     {{ $field['label'] }}
                  </label>
                  <input
                  type="{{ $field['type'] }}"
                  class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                  name="{{ $field['name'] }}"
                  id="{{ $field['name'] }}"
                  aria-describedby="{{ $field['name'] }}Help"
                  placeholder="Enter a new {{ $field['label'] }}"
                  {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}
                  value="{{ $params[$field['name']] ?? old($field['name']) }}">
               </div>
               @endforeach
            @endif
            @if(array_key_exists('textareas',$form))
               @foreach($form['textareas'] as $field)
               <div class="mb-6">
                  <label for="{{ $field['name'] }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                     {{ $field['label'] }}
                  </label>
                  <textarea
                  class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                  name="{{ $field['name'] }}"
                  id="{{ $field['name'] }}"
                  aria-describedby="{{ $field['name'] }}Help"
                  placeholder="Enter a new {{ $field['label'] }}"
                  {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>{!! $params[$field['name']] ?? old($field['name']) !!}</textarea>
               </div>
               @endforeach
            @endif
            @if(array_key_exists('selects',$form))
               @foreach($form['selects'] as $field)
               <div class="mb-6">
                  <label for="{{ $field['name'] }}" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">
                     {{ $field['label'] }}
                  </label>
                  <select
                  class="w-full px-3 py-2 placeholder-gray-300 leading-tight border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
                  name="{{ $field['name'].($field['multiple'] ? '[]' : '') }}"
                  id="{{ $field['name'] }}"
                  aria-describedby="{{ $field['name'] }}Help"
                  placeholder="Select a {{ $field['label'] }}"
                  {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>
                     @if(!$field['multiple'])
                     <option value="">Select a {{ $field['label'] }}</option>
                     @endif
                     @foreach($field['options'] as $option)
                     <option
                     value="{{ $option->id }}"
                     @if($field['multiple'])
                        @if(isset($params[$field['name']]))
                        {{ in_array($option->id, $params[$field['name']]) ? 'selected' : '' }}
                        @else
                        {{ old($field['name']) && in_array($option->id, old($field['name'])) ? 'selected' : ''}}
                        @endif
                     @else
                        @if(isset($params[$field['name']]))
                        {{ $params[$field['name']] == $option->id ? 'selected' : '' }}
                        @else
                        {{ old($field['name']) == $option->id ? 'selected' : ''}}
                        @endif
                     @endif>
                        {{ $option->name}}
                     </option>
                     @endforeach
                  </select>
               </div>
               @endforeach
            @endif
            @if(array_key_exists('checkboxes',$form))
            <div class="mb-6">
               @foreach($form['checkboxes'] as $field)
                  <label for="{{ $field['name'] }}" class="inline-flex items-center">
                     <input
                     type="checkbox"
                     class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                     name="{{ $field['name'] }}"
                     id="{{ $field['name'] }}"
                     aria-describedby="{{ $field['name'] }}Help"
                     {{ old($field['name']) ? 'checked' : ''}}
                     {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>
                     <span class="ml-2 text-sm text-gray-600">{{ $field['label'] }}</span>
                  </label>
               @endforeach
            </div>
            @endif
            <x-button type="submit">{{ __('Create '.$resource['name']) }}</x-button>
         </form>
      </div>
   </div>
</x-rancor::admin-layout>