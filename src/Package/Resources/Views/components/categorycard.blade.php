<div class="border w-full md:w-3/4 md:rounded overflow-hidden md:shadow-lg mb-4 md:mb-0">
   <div class="border-b p-4 text-white" style="background-color: {{ $category->color }}">
      <a href="{{ route('forums.category', $category) }}">
         {{ $category->name }}
      </a>
   </div>

   @if($category->boards_count > 0)
   <table class="table table-bordered">
      <thead>
         <tr class="d-flex">
            <th scope="col" class="col-9">Boards</th>
            <th scope="col" class="col-3">Latest</th>
         </tr>
      </thead>
      <tbody>
         {{-- @foreach($category->boards as $board)
         @include('rancor::forums.includes.boardrow',['board' => $board])
         @endforeach --}}
      </tbody>
   </table>
   @else
   <div class="card-body">No Boards found in this Category</div>
   @endif
</div>