@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-12">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('holocron.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Collections') }}</a></li>
            </ol>
         </nav>
      </div>
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  @foreach($collections as $collection)
                  <div class="col-sm-6 col-md-4 col-lg-3 mb-lg-5 mb-3">
                     <h5><a href="{{ route('holocron.collection.show', $collection) }}">{{ $collection->name }}</a></h5>
                     @if($collection->nodes->isNotEmpty())
                        @foreach ($collection->nodes as $node)
                           » <a href="{{ route('holocron.node.show', $node) }}">{{ $node->name }}</a><br />
                        @endforeach
                     @else
                        No nodes found in this collection
                     @endif
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection