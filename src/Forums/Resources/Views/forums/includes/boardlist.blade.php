<div class="card mb-4">
   <div class="card-header">{{ $header }}</div>
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
               <a class="h5" href="/forums/{{ $board->category->slug }}/{{ $board->slug }}">{{ __($board->title) }}</a><br>
               <span class="text-muted">{{ __($board->description) }}</span>
               @if(count($board->children) > 0)
               <br/><strong>Child Boards:</strong>
               @foreach ($board->children as $child)
               <a href="/forums/{{ $board->category->slug }}/{{ $child->slug }}">{{ $child->title}}</a>
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