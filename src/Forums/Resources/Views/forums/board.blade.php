@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('forums.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="{{ route('forums.category', ['category' => $category])}}" id="category-breadcrumb">{{$category->name}}</a></li>
               <li class="breadcrumb-item active">{{$board->name}}</li>
            </ol>
         </nav>
         @include('rancor::forums.includes.boardactions',['board' => $board])
         @if($board->children->isNotEmpty() || $sticky->isNotEmpty() || $normal->isNotEmpty())
         @if($board->children->isNotEmpty())
            @include('rancor::forums.includes.boardlist',['header' => 'Child Boards', 'board' => $board])
         @endif
         @if($sticky->isNotEmpty())
            @include('rancor::forums.includes.discussionlist',['header' => 'Sticky Discussions', 'discussions' => $sticky])
         @endif
         @if($normal->isNotEmpty())
            @include('rancor::forums.includes.discussionlist',['header' => 'Regular Discussions', 'discussions' => $normal])
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