<div class="card mb-4">
   <div class="card-header">{{ $header }}</div>
   <table class="table table-bordered">
      <thead>
         <tr class="d-flex">
            <th scope="col" class="col-9">Subject / Author</th>
            <th scope="col" class="col-3">Last Post</th>
         </tr>
      </thead>
      <tbody>
         @foreach($discussions as $discussion)
         @php
         $pages = ceil($discussion->replies_count / config('rancor.forums.pagination'));
         $index = $discussion->replies_count % config('rancor.forums.pagination');
         if($index == 0)
         {
            $index = config('rancor.forums.pagination');
         }
         @endphp
         <tr class="d-flex">
            <td class="col-9 px-4">
               <div class="row justify-content-between">
                  <a class="h5" href="/forums/{{ $discussion->board->category->slug }}/{{ $discussion->board->slug }}/{{ $discussion->id }}">{{ __($discussion->title) }}</a>
                  <div>
                     @if($discussion->is_locked)
                     <span class="badge badge-pill badge-danger">Locked</span>
                     @endif
                     <span class="badge badge-pill badge-primary">{{ __($discussion->views)}} Views</span>
                     <span class="badge badge-pill badge-primary">{{ __($discussion->replies_count)}} Replies</span>
                  </div>
               </div>
               @if($pages > 1)
               <div class="tetx-sm">
               «
               @for($i = 1; $i <= $pages; $i++)
                  <a class="text-sm" href="/forums/{{ $discussion->board->category->slug }}/{{ $discussion->board->slug }}/{{ $discussion->id }}?page={{ $i }}">{{ $i }}</a>,
               @endfor
               »</div>
               @endif
               - <a href="/profile/{{ __($discussion->author->id) }}">{{ __($discussion->author->name) }}</a>
            </td>
            <td class="col-3">
               @if($discussion->replies_count > 0)
               <a href="/forums/{{ $discussion->board->category->slug }}/{{ $discussion->board->slug }}/{{ $discussion->id }}#{{ $index }}">{{ $discussion->latest_reply->created_at->diffForHumans() }}</a><br/>
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