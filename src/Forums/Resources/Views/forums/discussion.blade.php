@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{ route('forums.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
         <li class="breadcrumb-item"><a href="{{ route('forums.category', ['category' => $category ]) }}" id="category-breadcrumb">{{$category->name}}</a></li>
         <li class="breadcrumb-item"><a href="{{ route('forums.board', ['category' => $category, 'board' => $board ]) }}" id="board-breadcrumb">{{$board->name}}</a></li>
         <li class="breadcrumb-item active">{{$discussion->name}}</li>
      </ol>
   </nav>
   @include('rancor::forums.includes.discussionactions', ['links' => $replies->links(), 'category' => $category, 'board' => $board, 'discussion' => $discussion, ])
    <div class="row justify-content-center">
      <form class="col">
         @foreach($replies as $index => $reply)
         <div class="card mb-4" id="{{ $index + 1 }}">
            <div class="card-header">
               <div class="row justify-content-between px-4">
                  <span><a href="{{ route('profile.show', $reply->author) }}" class="h5">{{ $reply->author->name }}</a></span>
                  @if(Auth::user()->hasPermission('delete-forum-replies'))
                  <span><a href="#{{ $index + 1 }}" >#{{ $index + 1 }}</a> <input type="checkbox" name="delete[]" value="{{ $reply->id }}"/></span>
                  @endif
               </div> 
            </div>
            <div class="row">
               <div class="d-flex flex-column col-5 col-md-3 py-3 px-4 justify-content-start align-items-center">
                  <img src="{{ $reply->author->avatar}}" width="150" height="150"/>
                  <div class="align-self-stretch">
                     @if($reply->author->rank != null)
                     <span style="color: {{ $reply->author->rank->color }}">{{ $reply->author->rank->name }}</span><br>
                     <span>{{ $reply->author->rank->department->name }}</span><br>
                     @else
                     Guest
                     @endif

                     @if($board->moderators->contains(Auth::user()))
                     Moderator<br>
                     @endif
                     
                     Posts: {{ $reply->author->replies_count }}<br>
                  </div>
               </div>
               <div class="col col-7 col-md-9 border-left py-3 px-4">
                  {!!($reply->body) !!}
                  <hr>
                  {!! $reply->author->signature !!}
               </div>
            </div>
            <div class="card-footer">
               <div class="row align-items-center">
                  <div class="col small">Posted {{ $reply->created_at->diffForHumans() }}@if($reply->editor != null). Last Edited by: {{ $reply->editor->name . ' '. $reply->updated_at->diffForHumans() }}@endif</div>
                  <div class="col text-right">
                     <a type="button" class="btn btn-sm btn-secondary" href="{{ route('forums.replies.create',[ 'discussion_id' => $discussion->id, 'quote' => $reply->id ]) }}">Quote</a>
                     @can('update',$reply)
                     <a type="button" class="btn btn-sm btn-secondary" href="{{ route('forums.replies.edit',[ 'reply' => $reply ]) }}">Edit</a>
                     @endcan
                     @can('delete',$reply)
                     <button type="button" class="btn btn-sm btn-secondary" href="#">Delete</button>
                     @endcan
                  </div>
               </div>
            </div>
         </div>
         @endforeach
      </form>
   </div>
   @include('rancor::forums.includes.discussionactions', ['links' => $replies->links() ])
</div>
@endsection