@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$discussion->board->category->slug}}" id="category-breadcrumb">{{$discussion->board->category->title}}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$discussion->board->category->slug}}/{{$discussion->board->slug}}" id="board-breadcrumb">{{$discussion->board->title}}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$discussion->board->category->slug}}/{{$discussion->board->slug}}/{{$discussion->id}}" id="discussion-breadcrumb">{{$discussion->title}}</a></li>
               <li class="breadcrumb-item active">{{ __('Reply') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Reply to "'.$discussion->title.'"') }}
            </div>
            <div class="card-body">
               <form action="/forums/replies/{{ $reply->id}}" method="POST">
                  @method('PATCH')
                  @csrf
                  <input type="hidden" name="discussion_id" id="discussion_id" value="{{ $discussion->id }}">
                  <div class="form-group">
                     <label for="body">Body</label>
                     <textarea rows="5" class="form-control" name="body" id="body" aria-describedby="bodyHelp">{{ $reply->body }}</textarea>
                     @error('body')
                     <small id="bodyHelp" class="form-text text-danger">{{ $message }}</small>
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