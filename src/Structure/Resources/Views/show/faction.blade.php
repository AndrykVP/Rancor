@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4 align-items-center">
            <div class="col text-right">
               <a href="{{ route('admin.factions.edit', $faction) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $faction->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $faction->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $faction->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $faction->description }}</div>
               </div>
               @if($faction->departments->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Departments:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($faction->departments as $department)
                        <li>{{ $department->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($faction->ranks->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Ranks:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($faction->ranks as $rank)
                        <li>{{ $rank->name }} ({{ $rank->level }})</li>
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