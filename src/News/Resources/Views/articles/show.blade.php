@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         @if(session('success'))
         <div class="alert alert-success" role="alert">
            {{ session('success') }}
         </div>
         @endif
         <div class="row flex justify-content-between mb-4">
            <div class="col">
               <a href="{{ route('articles.create') }}" class="btn btn-primary">New Article</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               <div class="row justify-content-between">
                  <div class="col">
                     {{ $article->title }}
                  </div>
                  <div class="col text-right">
                     {{ $article->is_published ? "Published" : "Drafted" }}
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row mb-4">
                  {!! $article->body !!}
               </div>
               <div class="row justify-content-end">
                  <p class="small text-muted text-right">
                     Written by <a href="{{ route('users.show',$article->author) }}">{{ $article->author->name }}</a> on {{ $article->created_at->format(config('rancor.dateFormat')) }}
                     @if($article->editor != null))
                     <br />Last edition by <a href="{{ route('users.show',$article->editor) }}">{{ $article->editor->name }}</a> on {{ $article->updated_at->format(config('rancor.dateFormat')) }}
                     @endif
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection