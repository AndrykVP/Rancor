@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         @if($errors)
         @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
         @endforeach
         @endif
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$board->category->slug}}" id="category-breadcrumb">{{ $board->category->title }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$board->category->slug}}/{{$board->slug}}" id="board-breadcrumb">{{ $board->title }}</a></li>
               <li class="breadcrumb-item active">{{ __('New Topic') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Create Topic on "'.$board->title.'"') }}
            </div>
            <div class="card-body">
               <form action="/forums/discussions" method="POST">
                  @csrf
                  <input type="hidden" name="board_id" id="board_id" value="{{$board->id}}">
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" placeholder="Enter a new title">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <div class="form-check form-check-inline">
                        <input  type="checkbox" class="form-check-input" name="is_sticky" id="is_sticky" aria-describedby="stickyHelp" value="1">
                        <label class="form-check-label" for="is_sticky">Make Sticky</label>
                     </div>
                     <div class="form-check form-check-inline">
                        <input  type="checkbox" class="form-check-input" name="is_locked" id="is_locked" aria-describedby="lockedHelp" value="1">
                        <label class="form-check-label" for="is_locked">Lock</label>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="body">Body</label>
                     <textarea rows="5" class="form-control @error('body')border border-danger @enderror" name="body" id="body" aria-describedby="bodyHelp"></textarea>
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