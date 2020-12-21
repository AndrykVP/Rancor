@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-between">
      <div class="col-6">
         <a class="btn btn-primary" href="{{ route('scanner.index')}}">Search</a>
         <a class="btn btn-success" href="{{ route('entries.create')}}">Upload</a>
      </div>
      <div class="col-6">
         {!! $entries->links() !!}
      </div>
   </div>
   <div class="card">
      <div class="card-header">All Scanner Entries</div>
      @include('rancor::includes.scannertable', ['entries' => $entries] )
   </div>
</div>
@endsection