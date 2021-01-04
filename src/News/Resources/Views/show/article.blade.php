@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $article->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $article->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Title:</div>
                  <div class="col-8">{{ $article->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Status:</div>
                  <div class="col-8 {{ $article->is_published ? 'text-success' : 'text-danger' }}">{{ $article->is_published ? 'Published' : 'Drafted' }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Views:</div>
                  <div class="col-8">{{ number_format($article->views) }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Author:</div>
                  <div class="col-8">{{ $article->author->name }}</div>
               </div>
               @if($article->editor != null)
               <div class="row mb-2">
                  <div class="col-4 text-right">Editor:</div>
                  <div class="col-8">{{ $article->editor->name }}</div>
               </div>
               @endif
               @if($article->tags->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Tags:</div>
                  <div class="col-8">
                     @foreach($article->tags as $tag)
                     <span class="badge badge-primary" style="background-color: {{ $tag->color}};">{{ $tag->name }}</span>
                     @endforeach
                  </div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection