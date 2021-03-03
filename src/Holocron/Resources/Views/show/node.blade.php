@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.nodes.edit', $node) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $node->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $node->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Title:</div>
                  <div class="col-8">{{ $node->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Status:</div>
                  <div class="col-8 {{ $node->is_public ? 'text-success' : 'text-danger' }}">{{ $node->is_public ? 'Public' : 'Private' }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Author:</div>
                  <div class="col-8">{{ $node->author->name }}</div>
               </div>
               @if($node->editor != null)
               <div class="row mb-2">
                  <div class="col-4 text-right">Last Editor:</div>
                  <div class="col-8">{{ $node->editor->name }}</div>
               </div>
               @endif
               @if($node->collections->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Collections:</div>
                  <div class="col-8">
                     @foreach($node->collections as $collection)
                     <span class="badge badge-primary">{{ $collection->name }}</span>
                     @endforeach
                  </div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection