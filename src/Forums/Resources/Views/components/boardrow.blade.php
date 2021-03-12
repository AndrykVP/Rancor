<tr class="d-flex">
   <td class="col-9">
      <div class="row justify-content-between px-3">
         <a class="h5" href="/forums/{{ $category->slug }}/{{ $board->slug }}">{{ __($board->name) }}</a>
         <div>
            <span class="badge badge-pill badge-primary">{{ __($board->discussions_count)}} Topics</span>
            <span class="badge badge-pill badge-primary">{{ __($board->replies_count)}} Replies</span>
         </div>
      </div>
      <span class="text-muted">{{ __($board->description) }}</span>
      @if(count($board->children) > 0)
      <br/><strong>Child Boards:</strong>
      @foreach ($board->children as $child)
      » <a href="/forums/{{ $category->slug }}/{{ $child->slug }}">{{ $child->name}}</a>
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
      <strong>In:</strong> <a href="{{ route('forums.discussion', ['category' => $board->category, 'board' => $board, 'discussion' => $board->latest_reply->discussion]) }}">{{ $board->latest_reply->discussion->name}}</a><br/>
      By: <a href="{{ route('profile.index', ['user' => $board->latest_reply->author]) }}">{{ $board->latest_reply->author->name }}</a>
      @else
      No Posts Yet
      @endif
   </td>
</tr>