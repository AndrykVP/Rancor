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
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Categories') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Order</th>
                      <th scope="col">Title</th>
                      <th scope="col">URL</th>
                      <th scope="col">Color</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($categories as $category)
                     <tr>
                        <th scope="row">{{ $category->order }}</th>
                        <td>{{ $category->title }}</td>
                        <td><a href="/forums/{{ $category->slug }}">{{ $category->slug }}</a></td>
                        <td>
                           <svg fill="{{ $category->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                              <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                           </svg>
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