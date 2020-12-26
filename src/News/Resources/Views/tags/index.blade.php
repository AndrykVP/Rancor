@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         @if(session('success'))
         <div class="alert alert-success" role="alert">
            {{ session('success') }}
         </div>
         @endif
         <div class="row flex justify-between">
            <div class="col">
               {!! $tags->links() !!}
            </div>
            <div class="col">
               <a href="{{ route('tags.create') }}" class="btn btn-primary">New Tag</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Tags') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Color</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($tags as $tag)
                    <tr>
                        <th scope="row">{{ $tag->id }}</th>
                        <td>{{ $tag->name }}</td>
                        <td>
                           <svg fill="{{ $tag->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                              <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                           </svg>
                        </td>
                        <td>
                           <a href="{{ route('tags.show',$tag) }}" class="btn btn-primary btn-sm">{{ __('View') }}</a>
                           <a href="{{ route('tags.edit',$tag) }}" class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                           <a href="{{ route('tags.destroy',$tag) }}" class="btn btn-danger btn-sm"
                              onclick="event.preventDefault();
                              document.getElementById('{{ 'delete-tag-' . $tag->id }}').submit();">
                              {{ __('Delete') }}
                           </a>

                           <form id="{{ 'delete-tag-' . $tag->id }}" action="{{ route('tags.destroy',$tag) }}" method="POST" style="display: none;">
                              @method('DELETE')
                              @csrf
                           </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection