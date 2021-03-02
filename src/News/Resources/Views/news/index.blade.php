@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row mb-4">
      <div class="col">
         <h1>{{ __('News Articles') }}</h1>
      </div>
      <div class="col">
         {{ $articles->links() }}
      </div>
   </div>
   <div class="row">
      <main class="col-md-8">
         @if($articles->isNotEmpty())
         <div id="accordion">
            @foreach ($articles as $article)
            <div class="card mb-4">
               <div class="card-header" id="heading{{ $article->id }}">
                  <a class="btn btn-link" href="{{ route('news.show', $article) }}">
                     {{ $article->name }}
                  </a>
                  @can('update', $article)
                  <a href="{{ route('admin.articles.edit',$article) }}" class="btn btn-success btn-sm" title="{{ __('Edit') }}">
                     <svg width="18" height="18" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                     </svg>
                  </a>
                  @endcan
               </div>

               <div id="{{ $article->id }}" aria-labelledby="heading{{ $article->id }}">
                  <div class="card-body">
                     {!! $article->description !!}
                     <hr>
                     <div class="row">
                        <div class="col">
                           @foreach($article->tags as $tag)
                           <a href="{{ route('news.tagged', $tag) }}"><span class="badge badge-primary" style="background-color: {{ $tag->color }};">#{{ $tag->name }}</span></a>
                           @endforeach
                        </div>
                        <div class="col text-right">
                           @if($article->is_published)
                           <small>Published {{ $article->published_at->diffForHumans() }} by <a href="{{ route('admin.users.show', ['user' => $article->author]) }}">{{ $article->author->name }}</a></small><br />
                           @else
                           <small>Created {{ $article->created_at->diffForHumans() }} by <a href="{{ route('admin.users.show', ['user' => $article->author]) }}">{{ $article->author->name }}</a></small><br />
                           @endif
                           @if($article->editor != null)
                           <small>Last edited {{ $article->updated_at->diffForHumans() }} by <a href="{{ route('admin.users.show', ['user' => $article->editor]) }}">{{ $article->editor->name }}</a></small><br />
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
         @else
         <h3 class="lead">No Articles found</h3>
         @endif
      </main>
      <aside class="col-md-4">
         <div class="card">
            <div class="card-header">Tags</div>
            <div class="card-body">
               @foreach($tags as $tag)
               <a href="{{ route('news.tagged', ['tag' => $tag]) }}"><span class="badge badge-primary" style="background-color: {{ $tag->color }};">#{{ $tag->name }}</span></a>
               @endforeach
            </div>
         </div>
      </aside>
   </div>
</div>
@endsection