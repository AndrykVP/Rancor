@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4 align-items-center">
            <div class="col text-right">
               <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $permission->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $permission->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $permission->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $permission->description }}</div>
               </div>
               @if($permission->users->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($permission->users as $user)
                        <li>{{ $user->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($permission->roles->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Roles:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($permission->roles as $role)
                        <li>{{ $role->name }}</li>
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