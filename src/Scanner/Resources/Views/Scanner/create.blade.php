@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center mb-4">
      <div class="col-md-10">
         <form action="{{ route('entries.store')}}" method="POST">
            @csrf
         </form>
      </div>
   </div>
</div>
@endsection