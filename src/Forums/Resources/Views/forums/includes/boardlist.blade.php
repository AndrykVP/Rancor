<div class="card mb-4">
   <div class="card-header">{{ $header }}</div>
   <table class="table table-bordered">
      <thead>
         <tr class="d-flex">
            <th scope="col" class="col-9">Boards</th>
            <th scope="col" class="col-3">Latest</th>
         </tr>
      </thead>
      <tbody>
         @foreach($board->children as $board)
         @include('rancor::forums.includes.boardrow',['board' => $board])
         @endforeach
      </tbody>
   </table>
</div>