@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.awards.edit', $award) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $award->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $award->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $award->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $award->description }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Code:</div>
                  <div class="col-8">{{ $award->code }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Type:</div>
                  <div class="col-8">{{ $award->type->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Levels:</div>
                  <div class="col-8">{{ $award->levels }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Priority:</div>
                  <div class="col-8">{{ $award->priority }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">{{ number_format($award->user_count) }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Image:</div>
                  <div class="col-8"><img src="{{ asset('storage/awards/'.$award->code.'.png') }}" /></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection