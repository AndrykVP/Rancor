@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-content-between mb-4">
            <div class="col">
               <a href="{{ route('tags.create') }}" class="btn btn-primary">New Tag</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               <div class="row justify-content-between">
                  <div class="col">
                     {{ __('Tag') . ' ' .$tag->name }}
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col">
                     Color: 
                     <svg fill="{{ $tag->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                        <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                     </svg>
                  </div>
                  <div class="col">Articles: {{ $tag->articles_count }}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection