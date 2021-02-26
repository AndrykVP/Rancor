@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-between align-items-center mb-4">
            <div class="col">
               {!! $replies->links() !!}
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Reply List') }}
            </div>
            <ul class="list-group list-group-flush">
               @foreach($replies as $reply)
               <li class="list-group-item" id="{{ $reply->id }}">
                  <p class="small">Posted {{ $reply->created_at->diffForHumans() }} in <a href="{{ route('forums.discussion', [
                     'category' => $reply->discussion->board->category,
                     'board' => $reply->discussion->board,
                     'discussion' => $reply->discussion,
                     'page' => $reply->page->number
                  ]) }}#{{ $reply->page->index }}">{{ $reply->discussion->name }}</a></p>
                  {!! clean($reply->body) !!}
               </li>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
@endsection