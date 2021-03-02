@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row mb-4">
      <div class="col">
         <h1>{{ __('News Article') }}</h1>
      </div>
      <div class="col">
         <div class="row justify-between">
            @can('update', $article)
            <a href="{{ route('admin.articles.edit',$article) }}" class="btn btn-success" title="{{ __('Edit') }}">
               {{ __('Edit') }}
            </a>
            @endcan
            @can('delete', $article)
            <button class="btn btn-danger ml-2" title="{{ __('Delete') }}">
               {{ __('Delete') }}
            </button>
            @endcan
         </div>
      </div>
   </div>
   <div class="row">
      <main class="col-md-8">
         <div class="card mb-4">
            <div class="card-header" id="heading{{ $article->id }}">
               {{ $article->name }}
            </div>

            <div id="{{ $article->id }}" aria-labelledby="heading{{ $article->id }}">
               <div class="card-body">
                  {!! $article->body !!}
                  <hr>
                  <div class="row">
                     <div class="col">
                        @foreach($article->tags as $tag)
                        <a href="{{ route('news.tagged', ['tag' => $tag]) }}"><span class="badge badge-primary" style="background-color: {{ $tag->color }};">#{{ $tag->name }}</span></a>
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