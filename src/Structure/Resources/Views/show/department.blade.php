@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $department->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $department->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $department->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $department->description }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Faction:</div>
                  <div class="col-8">{{ $department->faction->name }}</div>
               </div>
               @if($department->ranks->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Ranks:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($department->ranks as $rank)
                        <li>{{ $rank->name }} ({{ $rank->level }})</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($department->users->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($department->users as $user)
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