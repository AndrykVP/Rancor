@extends(config('rancor.forums.layout'))

@php
$board_count =  count($board->children);
$sticky_count = count($sticky);
$normal_count = count($normal);
@endphp

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$board->category->slug}}" id="category-breadcrumb">{{$board->category->title}}</a></li>
               <li class="breadcrumb-item active">{{$board->title}}</li>
            </ol>
         </nav>
         <div class="d-flex flex-row justify-content-between align-items-center p-0 mb-2">
            <div class="btn-group" role="group" aria-label="Board Actions">
               <a type="button" class="btn btn-success" href="{{ route('forums.replies.create', [ 'board' => $board ]) }}">New Topic</a>
               @can('update',$board)
               <a type="button" class="btn btn-primary" href="{{ route('forums.boards.edit', [ 'board' => $board ]) }}">Modify Board</a>
               @endcan
               @can('create',$board)
               <a type="button" class="btn btn-secondary" href="{{ route('forums.boards.create', [ 'board' => $board ]) }}">New Child Board</a>
               @endcan
               @can('delete',$board)
               <a type="button" class="btn btn-danger" href="#">Delete Board</a>
               @endcan
            </div>
         </div>
         @if($board_count > 0 || $sticky_count > 0 || $normal_count > 0)
         @if($board_count > 0)
            @include('rancor::forums.includes.boardlist',['header' => 'Child Boards', 'board' => $board])
         @endif
         @if($sticky_count > 0)
            @include('rancor::forums.includes.discussionlist',['header' => 'Sticky Discussions', 'discussions' => $sticky])
         @endif
         @if($normal_count > 0)
            @include('rancor::forums.includes.discussionlist',['header' => 'Normal Discussions', 'discussions' => $normal])
         @endif
         @else
         <div class="row justify-content-center">
            <div class="col">
               <div class="card mb-4">
                  <div class="card-body">No Child Boards or Discussions found in this Board</div>
               </div>
            </div>
         </div>
         @endif
      </div>
   </div>
</div>
@endsection