<div x-data="{show: true}">
   <div x-show.transition="show" class="relative flex justify-between bg-{{ $color }}-100 rounded overflow-hidden p-2 space-x-1">
      <div class="absolute inset-0 border-l-4 border-{{ $color }}-400"></div>
      <div class="flex items-baseline">
         <span class="bg-{{ $color }}-300 bg-opacity-50 rounded-full p-1">
         </span>
      </div>
      <div class="flex flex-grow items-center">
      <p class="leading-tight text-xs md:text-sm">{{ $message }}</p>
      </div>
      <div class="z-10">
         <button @click="show = false" type="button" class="bg-indigo-300 bg-opacity-25 text-gray-700 rounded overflow-hidden p-1 lg:p-2 focus:outline-none">
            <svg class="h-4 w-auto" fill="currentColor" viewBox="0 0 20 20">
               <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
         </button>
      </div>
   </div>
</div>