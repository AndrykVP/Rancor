@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $tag->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $tag->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $tag->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Color:</div>
                  <div class="col-8">{{ strtoupper($tag->color) }}
                     <svg fill="{{ $tag->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                        <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                     </svg>
                  </div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Usage Count:</div>
                  <div class="col-8">{{ number_format($tag->articles_count) }}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection