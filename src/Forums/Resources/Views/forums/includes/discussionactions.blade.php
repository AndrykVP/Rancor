
<div class="d-flex flex-row justify-content-between align-items-center mb-2">
   <div class="btn-group">
      <a type="button" class="btn btn-sm btn-success" href="{{ route('forums.replies.create',[ 'discussion' => $discussion ]) }}">Post Reply</a>
      @can('update',$discussion)
      <a type="button" class="btn btn-sm btn-primary" href="{{ route('forums.discussions.edit', [ 'discussion' => $discussion ]) }}">Modify Topic</a>
      @endcan
      @can('delete',$discussion)
      <a type="button" class="btn btn-sm btn-danger" href="#">Delete Topic</a>
      <a type="button" class="btn btn-sm btn-danger" href="#">Delete Selected Replies</a>
      @endcan
   </div>
   {!! $links !!}
</div>