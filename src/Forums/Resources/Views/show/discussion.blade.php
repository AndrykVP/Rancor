@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.discussions.edit', $discussion) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $discussion->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $discussion->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $discussion->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Board:</div>
                  <div class="col-8">{{ $discussion->board->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Status:</div>
                  <div class="col-8">
                     <span class="badge badge-{{ $discussion->is_locked ? 'danger' : 'primary' }}">{{ $discussion->is_locked ? 'Locked' : 'Open' }}</span>
                     <span class="badge badge-{{ $discussion->is_sticky ? 'danger' : 'primary' }}">{{ $discussion->is_sticky ? 'Sticky' : 'Regular' }}</span>
                  </div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Total Replies:</div>
                  <div class="col-8">{{ number_format($discussion->replies_count) }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Total Views:</div>
                  <div class="col-8">{{ number_format($discussion->views) }}</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection