<x-rancor::main-layout>
   <x-slot name="header">
      <div class="flex flex-col md:flex-row justify-between">
         <ul class="flex text-sm lg:text-base">
            <li class="inline-flex items-center">
               <a class="text-indigo-900 hover:text-indigo-700" href="{{ route('scanner.index') }}">{{ __('Scanner') }}</a>
               <svg class="h-5 w-auto text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
               </svg>
            </li>
            <li class="inline-flex items-center text-gray-500">
               {{ __('Upload') }}
            </li>
         </ul>
      </div>
   </x-slot>

   <x-auth-validation-errors class="mb-4" :errors="$errors" />
   <div class="py-12">
      <form action="{{ route('scanner.store') }}" method="POST" enctype="multipart/form-data" x-data="{ files: null, active: false }" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
         @csrf
         <div class="block w-full py-2 px-3 relative bg-white appearance-none border border-solid rounded-md hover:shadow-outline-blue" :class="active ? 'text-blue-700 border-blue-300' : 'text-gray-700 border-gray-300'">
            <input type="file" name="scans[]" accept="text/xml" multiple
                  class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                  x-on:change="files = $event.target.files; console.log(files);"
                  x-on:dragover="active = true" x-on:dragleave="active = false" x-on:drop="active = false"
            >
            <template x-if="files !== null">
               <div class="flex flex-col space-y-1">
                  <template x-for="file in Array.from(files)">
                     <div class="flex items-center space-x-2">
                        <span class="font-medium text-gray-900" x-text="file.name">Uploading</span>
                        <span class="text-xs self-end text-gray-500" x-text="filesize(file.size)">...</span>
                     </div>
                  </template>
               </div>
            </template>
            <template x-if="files === null">
               <div class="flex flex-col space-y-2 items-center justify-center">
                  <p>
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                     </svg>
                  </p>
                  <p>Drag your files here or click in this area.</p>
               </div>
            </template>
         </div>
         <template x-if="files !== null">
            <div class="flex flex-row justify-center items-center mt-8">
               <button class="py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-green-700 hover:bg-green-500" type="submit" x-text="'Upload ' + files.length + ' Scans'">Upload All</button>
               <button class="ml-4 py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700 hover:bg-red-500" @click="files = null" type="button">Clear</button>
            </div>
         </template>
      </form>
   </div>
  
</x-rancor::main-layout>

<script>
function filesize(size) {
   if(size > 1000) {
      return Math.ceil(size / 1000) + ' KB'
   }
   if(size > 1000000) {
      return Math.ceil(size / 1000000) + ' MB'
   }
   return '1 KB'
}
</script>