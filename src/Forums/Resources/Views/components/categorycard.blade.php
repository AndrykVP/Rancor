<div class="card mb-4">
   <div class="card-header text-white" style="background-color: {{ __($category->color) }}"><a href="/forums/{{ __($category->slug)}}" class="text-white">{{ __($category->name)}}</a></div>
   @if($category->boards_count > 0)
   <table class="table table-bordered">
      <thead>
         <tr class="d-flex">
            <th scope="col" class="col-9">Boards</th>
            <th scope="col" class="col-3">Latest</th>
         </tr>
      </thead>
      <tbody>
         @foreach($category->boards as $board)
         @include('rancor::forums.includes.boardrow',['board' => $board])
         @endforeach
      </tbody>
   </table>
   @else
   <div class="card-body">No Boards found in this Category</div>
   @endif
</div>