@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.ranks.edit', $rank) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $rank->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $rank->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $rank->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $rank->description }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Department:</div>
                  <div class="col-8">{{ $rank->department->name }}</div>
               </div>
               @if($rank->users->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($rank->users as $user)
                        <li>{{ $user->name }}</li>
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