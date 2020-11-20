@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="/forums" id="index-breadcrumb">{{ __('Index') }}</a></li>
         <li class="breadcrumb-item"><a href="/forums/category/{{$board->category->slug}}" id="category-breadcrumb">{{$board->category->title}}</a></li>
      </ol>
   </nav>
   @if(count($board->children) > 0)
   <div class="row justify-content-center">
      <div class="col">
         <div class="card mb-4">
            <div class="card-header">{{ __('Child Boards') }}</div>
            <table class="table table-bordered">
               <thead>
                  <tr class="d-flex">
                     <th scope="col" class="col-8">Boards</th>
                     <th scope="col" class="col-2">Latest</th>
                     <th scope="col" class="col-1">Topics</th>
                     <th scope="col" class="col-1">Replies</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($board->children as $board)
                  <tr class="d-flex">
                     <td class="col-8">
                        <a class="h5" href="/forums/board/{{ $board->slug }}">{{ __($board->title) }}</a><br>
                        <span class="text-muted">{{ __($board->description) }}</span>
                        @if(count($board->children) > 0)
                        <br/><strong>Child Boards:</strong>
                        @foreach ($board->children as $child)
                        <a href="/forums/{{ $child->slug }}">{{ $child->title}}</a>
                        @endforeach
                        @endif
                     </td>
                     <td class="col-2">
                        @if($board->replies_count > 0)
                        {{ $board->latest_reply->created_at->format(config('rancor.dateFormat')) }}<br/>
                        <strong>In:</strong> <a href="discussion/{{ $board->latest_reply->discussion->title}}">{{ $board->latest_reply->discussion->title}}</a><br/>
                        By: <a href="profile/{{ $board->latest_reply->author->id }}">{{ $board->latest_reply->author->name }}</a>
                        @else
                        No Posts Yet
                        @endif
                     </td>
                     <td class="col-1">{{ __($board->discussions_count)}}</td>
                     <td class="col-1">{{ __($board->replies_count)}}</td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endif
   @if(count($sticky) > 0)
   <div class="row justify-content-center">
      <div class="col">
         <div class="card mb-4">
            <div class="card-header">{{ __('Sticky Discussions') }}</div>
            <table class="table table-bordered">
               <thead>
                  <tr class="d-flex">
                     <th scope="col" class="col-8">Subject / Author</th>
                     <th scope="col" class="col-1">Replies</th>
                     <th scope="col" class="col-1">Views</th>
                     <th scope="col" class="col-2">Last Post</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($sticky as $discussion)
                  <tr class="d-flex">
                     <td class="col-8">
                        <a class="h5" href="/forums/discussion/{{ $discussion->id }}">{{ __($discussion->title) }}</a><br>
                        <a href="/profile/{{ __($discussion->author->id) }}">{{ __($discussion->author->name) }}</a>
                     </td>
                     <td class="col-1">{{ __($discussion->replies_count)}}</td>
                     <td class="col-1">{{ __($discussion->views)}}</td>
                     <td class="col-2">
                        @if($discussion->replies_count > 0)
                        {{ $discussion->latest_reply->created_at->format(config('rancor.dateFormat')) }}<br/>
                        By: <a href="profile/{{ $discussion->latest_reply->author->id }}">{{ $discussion->latest_reply->author->name }}</a>
                        @else
                        No Posts Yet
                        @endif
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endif
   @if(count($normal) > 0)
   <div class="row justify-content-center">
      <div class="col">
         <div class="card mb-4">
            <div class="card-header">{{ __('Discussions') }}</div>
            <table class="table table-bordered">
               <thead>
                  <tr class="d-flex">
                     <th scope="col" class="col-8">Subject / Author</th>
                     <th scope="col" class="col-1">Replies</th>
                     <th scope="col" class="col-1">Views</th>
                     <th scope="col" class="col-2">Last Post</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($normal as $discussion)
                  <tr class="d-flex">
                     <td class="col-8">
                        <a class="h5" href="/forums/discussion/{{ $discussion->id }}">{{ __($discussion->title) }}</a><br>
                        <a href="/profile/{{ __($discussion->author->id) }}">{{ __($discussion->author->name) }}</a>
                     </td>
                     <td class="col-1">{{ __($discussion->replies_count)}}</td>
                     <td class="col-1">{{ __($discussion->views)}}</td>
                     <td class="col-2">
                        @if($discussion->replies_count > 0)
                        {{ $discussion->latest_reply->created_at->format(config('rancor.dateFormat')) }}<br/>
                        By: <a href="profile/{{ $discussion->latest_reply->author->id }}">{{ $discussion->latest_reply->author->name }}</a>
                        @else
                        No Posts Yet
                        @endif
                     </td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
   @endif
</div>
@endsection