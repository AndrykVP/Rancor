@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Boards') }}</li>
            </ol>
         </nav>
         <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <div class="btn-group">
               <a class="btn btn-sm btn-success" href="{{ route('forums.boards.create') }}">New Board</a>
            </div>
         </div>
         @if(session('success'))
         <div class="alert alert-success" role="alert">
            {{ session('success') }}
         </div>
         @endif
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of boards') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">Order</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($boards as $board)
                     <tr>
                        <th scope="row">{{ $board->order }}</th>
                        <td>{{ $board->title }}</td>
                        <td>{{ $board->category->title }}</td>
                        <td>
                           <div class="btn-group">
                              <a class="btn btn-sm btn-success" href="/forums/{{ $board->category->slug }}/{{ $board->slug }}">{{ _('Visit') }}</a>
                              <a class="btn btn-sm btn-primary" href="{{ route('forums.boards.edit',['board' => $board]) }}">{{ _('Edit') }}</a>
                              <a class="btn btn-sm btn-danger" href="#">{{ _('Delete') }}</a>
                           </div>
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