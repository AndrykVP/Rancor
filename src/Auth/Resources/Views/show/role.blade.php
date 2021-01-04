@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4 align-items-center">
            <div class="col text-right">
               <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $role->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $role->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $role->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $role->description }}</div>
               </div>
               @if($role->users->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($role->users as $user)
                        <li>{{ $user->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($role->permissions->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Permissions:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($role->permissions as $permission)
                        <li>{{ $permission->name }}</li>
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