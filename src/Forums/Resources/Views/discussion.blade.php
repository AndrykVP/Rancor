@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
    <!--
    <nav aria-label="forum-pagination">
        <ul class="pagination">
            <li class="page-item disabled">
                <span class="page-link">Previous</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active">
            <span class="page-link">
                2
                <span class="sr-only">(current)</span>
            </span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
            <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
    -->
    <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
             <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
             <li class="breadcrumb-item"><a href="/forums/category/{{$discussion->board->category->slug}}" id="category-breadcrumb">{{$discussion->board->category->title}}</a></li>
             <li class="breadcrumb-item"><a href="/forums/board/{{$discussion->board->slug}}" id="board-breadcrumb">{{$discussion->board->title}}</a></li>
       </ol>
    </nav>
    <div class="row justify-content-center">
      <div class="col">
          <div class="card mb-4">
            <div class="card-header">{{ __($discussion->title) }}</div>
                @foreach($replies as $reply)
                <div class="row border-bottom">
                    <div class="col-md-3 py-3 px-4 text-center">
                        <img src="{{ $reply->author->avatar}}" /><br>
                        <a href="/profile/{{ $reply->author->id }}" class="h6">{{ $reply->author->name }}</a>
                    </div>
                    <div class="col-md-9 border-left py-3 px-4">
                        {{ __($reply->body) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection