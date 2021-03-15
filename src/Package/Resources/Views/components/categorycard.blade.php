<div class="border w-full md:rounded overflow-hidden md:shadow-lg mb-4">
   <div class="border-b p-4 text-white" style="background-color: {{ $category->color }}">
      <a href="{{ route('forums.category', $category) }}">
         {{ $category->name }}
      </a>
   </div>
   
   @if($category->boards_count > 0)
   <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
         <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Boards</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest</th>
         </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
         @foreach($category->boards as $board)
            <x-rancor::board-row :board="$board" />
         @endforeach
      </tbody>
   </table>
   @else
   <div class="card-body">No Boards found in this Category</div>
   @endif
</div>