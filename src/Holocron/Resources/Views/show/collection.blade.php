@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $collection->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $collection->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $collection->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">URL:</div>
                  <div class="col-8">{{ $collection->slug }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Node Count:</div>
                  <div class="col-8">{{ number_format($collection->nodes_count) }}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection