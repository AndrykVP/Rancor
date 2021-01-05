@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row">
      @foreach($cards as $card)
      <div class="col-6 col-md-3">
         <div class="card bg-info text-center mb-4">
            <div class="card-body">
               <p class="display-4">{{ $card['value'] }}</p>
               <h2 class="lead">{{ $card['title'] }}</h2>
            </div>
         </div>
      </div>
      @endforeach
   </div>
</div>
@endsection