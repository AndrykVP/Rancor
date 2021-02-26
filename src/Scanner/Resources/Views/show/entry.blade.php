@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.entries.edit', $entry) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $entry->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $entry->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Entity ID:</div>
                  <div class="col-8">#{{ $entry->entity_id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Type:</div>
                  <div class="col-8">{{ $entry->type }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $entry->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Owner:</div>
                  <div class="col-8">{{ $entry->owner }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Contributor:</div>
                  <div class="col-8">{{ $entry->contributor->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Last Update:</div>
                  <div class="col-8">{{ $entry->updated_at->diffForHumans() }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Changes:</div>
                  <div class="col-8">{{ number_format($entry->changelog_count) }}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection