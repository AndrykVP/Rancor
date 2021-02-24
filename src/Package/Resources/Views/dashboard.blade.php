@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row">
      @foreach($cards as $card)
      <div class="col-6 col-md-4">
         <div class="card bg-primary text-white text-center mb-4">
            <div class="card-body">
               <div class="row">
                  <div class="col"><img src="https://s2.svgbox.net/hero-solid.svg?ic={{ $card['icon'] }}&color=ffffff" width="64" height="64"></div>
                  <div class="col">
                     <h2 class="lead">{{ $card['title'] }}</h2>
                     <h3>{{ $card['value'] }}</h3>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
</div>
@endsection