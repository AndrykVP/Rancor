@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$discussion->board->category->slug}}" id="category-breadcrumb">{{ __($discussion->board->category->title) }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$discussion->board->category->slug}}/{{$discussion->board->slug}}" id="board-breadcrumb">{{ __($discussion->board->title) }}</a></li>
               <li class="breadcrumb-item active">{{ __('Edit') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit Discussion "'.$discussion->title).'"' }}
            </div>
            <div class="card-body">
               <form action="/forums/discussions/{{ $discussion->id}}" method="POST">
                  @method('PATCH')
                  @csrf
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control @error('title')border border-danger @enderror" name="title" id="title" aria-describedby="titleHelp" value="{{ $discussion->title }}">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <div class="form-check form-check-inline">
                        <input  type="checkbox" class="form-check-input" name="is_sticky" id="is_sticky" aria-describedby="stickyHelp" value="1" {{ ($discussion->is_sticky ? ' checked' : '') }}>
                        <label class="form-check-label" for="is_sticky">Make Sticky</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input  type="checkbox" class="form-check-input" name="is_locked" id="is_locked" aria-describedby="lockedHelp" value="1" {{ ($discussion->is_locked ? ' checked' : '') }}>
                        <label class="form-check-label" for="is_locked">Lock</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="board">Move to Board (optional)</label>
                     <select class="form-control @error('board_id')border border-danger @enderror" name="board_id" id="board" aria-describedby="boardHelp">
                        @foreach($boards as $board)
                        <option value="{{ $board->id }}" {{ $discussion->board->id === $board->id ? 'selected' : ''}}>{{ $board->title }}</option>
                        @endforeach
                     </select>
                     @error('board_id')
                     <small id="boardHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection