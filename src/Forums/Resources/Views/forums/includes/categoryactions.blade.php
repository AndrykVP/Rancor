<div class="d-flex flex-row justify-content-between align-items-center mb-2">
   <div class="btn-group">
      @can('create', AndrykVP\Rancor\Forums\Board::class)
      <a type="button" class="btn btn-sm btn-success" href="{{ route('admin.boards.create',[ 'category_id' => $category->id ]) }}">Create Board</a>
      @endcan
      @can('update',$category)
      <a type="button" class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', [ 'category' => $category ]) }}">Modify Category</a>
      @endcan
      @can('delete',$category)
      <a type="button" class="btn btn-sm btn-danger" href="#">Delete Category</a>
      @endcan
   </div>
</div>