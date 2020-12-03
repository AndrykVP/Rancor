@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{ $board->category->slug }}" id="category-breadcrumb">{{ __($board->category->title) }}</a></li>
               <li class="breadcrumb-item active">{{ __($board->title) }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Discussions in "'.$board->title.'"') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($board->discussions as $discussion)
                     <tr>
                        <th scope="row"><a href="/forums/{{ $board->category->slug }}/{{ $board->slug }}/{{ $discussion->id }}">{{ $discussion->id }}</a></th>
                        <td>{{ $discussion->title }}</td>
                     </tr>
                     @endforeach
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection