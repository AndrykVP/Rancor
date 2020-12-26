<div class="card mb-4">
   <div class="card-header text-white" style="background-color: {{ __($category->color) }}"><a href="/forums/{{ __($category->slug)}}" class="text-white">{{ __($category->title)}}</a></div>
   @if($category->boards_count > 0)
   <table class="table table-bordered">
      <thead>
         <tr class="d-flex">
            <th scope="col" class="col-9">Boards</th>
            <th scope="col" class="col-3">Latest</th>
         </tr>
      </thead>
      <tbody>
         @foreach($category->boards as $board)
         @include('rancor::forums.includes.boardrow',['board' => $board])
         <tr class="d-flex">
            <td class="col-9">
               <div class="row justify-content-between px-3">
                  <a class="h5" href="/forums/{{ $category->slug }}/{{ $board->slug }}">{{ __($board->title) }}</a>
                  <div>
                     <span class="badge badge-pill badge-primary">{{ __($board->discussions_count)}} Topics</span>
                     <span class="badge badge-pill badge-primary">{{ __($board->replies_count)}} Replies</span>
                  </div>
               </div>
               <span class="text-muted">{{ __($board->description) }}</span>
               @if(count($board->children) > 0)
               <br/><strong>Child Boards:</strong>
               @foreach ($board->children as $child)
               » <a href="/forums/{{ $category->slug }}/{{ $child->slug }}">{{ $child->title}}</a>
               @endforeach
               @endif
               @if(count($board->moderators) > 0)
               <br/><strong>Moderators:</strong>
               @foreach ($board->moderators as $moderator)
               » <a href="/profile/{{ $moderator->id }}">{{ $moderator->name}}</a>
               @endforeach
               @endif
            </td>
            <td class="col-3">
               @if($board->replies_count > 0)
               {{ $board->latest_reply->created_at->diffForHumans() }}<br/>
               <strong>In:</strong> <a href="/forums/{{ $category->slug }}/{{ $board->slug }}/{{ $board->latest_reply->discussion->id}}">{{ $board->latest_reply->discussion->title}}</a><br/>
               By: <a href="/profile/{{ $board->latest_reply->author->id }}">{{ $board->latest_reply->author->name }}</a>
               @else
               No Posts Yet
               @endif
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
   @else
   <div class="card-body">No Boards found in this Category</div>
   @endif
</div>