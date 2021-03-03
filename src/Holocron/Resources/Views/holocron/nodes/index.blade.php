@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-12">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('holocron.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Nodes') }}</li>
            </ol>
         </nav>
      </div>
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  @foreach($nodes as $letter => $nodes)
                  <div class="col-sm-6 col-md-4 col-lg-3 mb-lg-4 mb-3">
                     <h5>{{ $letter }}</h5>
                        @foreach ($nodes as $node)
                           » <a href="{{ route('holocron.node.show', $node['id']) }}">{{ $node['name'] }}</a><br />
                        @endforeach
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection