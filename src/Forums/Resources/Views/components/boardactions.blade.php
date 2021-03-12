<div class="row mb-4">
   <div class="col">
      <div class="btn-group" role="group" aria-label="Board Actions">
         <a type="button" class="btn btn-sm btn-success" href="{{ route('forums.discussions.create', [ 'board_id' => $board->id ]) }}">New Topic</a>
         @can('update',$board)
         <a type="button" class="btn btn-sm btn-primary" href="{{ route('admin.boards.edit', [ 'board' => $board ]) }}">Modify Board</a>
         @endcan
         @can('create', \AndrykVP\Rancor\Forums\Board::class)
         <a type="button" class="btn btn-sm btn-secondary" href="{{ route('admin.boards.create', [ 'parent_id' => $board->id ]) }}">New Child Board</a>
         @endcan
         @can('delete',$board)
         <a type="button" class="btn btn-sm btn-danger" href="#">Delete Board</a>
         @endcan
      </div>
   </div>
</div>