@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         {!! $replies->links() !!}
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Replies from '.$user->name) }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Content</th>
                      <th scope="col">Topic</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($replies as $reply)
                     <tr>
                        <td>{{ $reply->body }}</td>
                        <td>
                           {{ $reply->created_at->format(config('rancor.dateFormat')) }}<br/>
                           <strong>In:</strong> <a href="/forums/{{$reply->discussion->board->category->slug}}/{{$reply->discussion->board->slug}}/{{ $reply->discussion->id}}">{{ $reply->discussion->title}}</a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection