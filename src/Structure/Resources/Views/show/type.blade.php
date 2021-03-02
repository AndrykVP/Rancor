@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.types.edit', $type) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $type->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $type->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $type->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $type->description }}</div>
               </div>
               @if($type->awards->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Awards:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($type->awards as $award)
                        <li>{{ $award->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection